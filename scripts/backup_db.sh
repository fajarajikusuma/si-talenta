#!/usr/bin/env bash
# =============================================================================
# backup_db.sh — Backup database SI-Talenta + auto push ke GitHub
# Format file  : db-talenta-YYYYMMDD-HHMMSS.sql
# Perilaku     : simpan backup baru, hapus yang lama, commit & push ke GitHub
# =============================================================================

set -euo pipefail

# ── Konfigurasi database ──────────────────────────────────────────────────────
DB_HOST="localhost"
DB_PORT="3306"
DB_NAME="db_tenaga_kerja_dlh"
DB_USER="root"
DB_PASS="webdev"

# ── Path ──────────────────────────────────────────────────────────────────────
SCRIPT_DIR="$(cd "$(dirname "$0")" && pwd)"
PROJECT_DIR="$(cd "$SCRIPT_DIR/.." && pwd)"
BACKUP_DIR="${PROJECT_DIR}/backups"
LOG_FILE="${BACKUP_DIR}/backup.log"

mkdir -p "$BACKUP_DIR"

# ── Timestamp & nama file ─────────────────────────────────────────────────────
TIMESTAMP="$(date '+%Y%m%d-%H%M%S')"
FILENAME="db-talenta-${TIMESTAMP}.sql"
FILEPATH="${BACKUP_DIR}/${FILENAME}"

# ── Fungsi log ────────────────────────────────────────────────────────────────
log() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $*" | tee -a "$LOG_FILE"
}

log "=== Mulai backup: ${FILENAME} ==="

# ── mysqldump ─────────────────────────────────────────────────────────────────
if mysqldump \
    --host="$DB_HOST" \
    --port="$DB_PORT" \
    --user="$DB_USER" \
    --password="$DB_PASS" \
    --single-transaction \
    --routines \
    --triggers \
    --add-drop-table \
    --complete-insert \
    "$DB_NAME" > "$FILEPATH" 2>>"$LOG_FILE"; then

    SIZE="$(du -sh "$FILEPATH" | cut -f1)"
    log "Backup berhasil: ${FILENAME} (${SIZE})"
else
    log "ERROR: mysqldump gagal!"
    rm -f "$FILEPATH"
    exit 1
fi

# ── Hapus semua backup SQL lama (bukan yang baru saja dibuat) ─────────────────
DELETED=0
while IFS= read -r old_file; do
    if [ "$old_file" != "$FILEPATH" ]; then
        rm -f "$old_file"
        log "Hapus backup lama: $(basename "$old_file")"
        DELETED=$((DELETED + 1))
    fi
done < <(find "$BACKUP_DIR" -maxdepth 1 -name "db-talenta-*.sql" | sort)

log "${DELETED} backup lama dihapus. Tersisa: ${FILENAME}"

# ── Git commit & push ke GitHub ───────────────────────────────────────────────
cd "$PROJECT_DIR"

# Pastikan git terkonfigurasi
git config user.email "$(git config user.email 2>/dev/null || echo 'backup@si-talenta')"
git config user.name  "$(git config user.name  2>/dev/null || echo 'SI-Talenta Backup')"

log "Menambahkan file ke git..."

# Stage file backup baru + hapus referensi backup lama dari git
git add backups/
git add -u backups/ 2>/dev/null || true

COMMIT_MSG="update: new database-${TIMESTAMP}"

# Cek apakah ada perubahan yang perlu di-commit
if git diff --cached --quiet; then
    log "Tidak ada perubahan git untuk di-commit."
else
    git commit -m "$COMMIT_MSG"
    log "Commit: ${COMMIT_MSG}"

    # Push ke branch yang sedang aktif
    BRANCH="$(git rev-parse --abbrev-ref HEAD 2>/dev/null || echo 'main')"
    if git push origin "$BRANCH" >> "$LOG_FILE" 2>&1; then
        log "Push berhasil ke branch: ${BRANCH}"
    else
        log "ERROR: Push gagal. Cek log untuk detail."
        exit 1
    fi
fi

log "=== Selesai ==="
