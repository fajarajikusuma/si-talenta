# SI-Talenta — Sistem Informasi Tenaga Kerja DLH

Aplikasi pengelolaan data tenaga kerja non-ASN Dinas Lingkungan Hidup Kota Pekalongan, dibangun di atas **CodeIgniter 4** (PHP 8.1+).

---

## Daftar Isi

1. [Deskripsi Aplikasi](#deskripsi-aplikasi)
2. [Persyaratan Server](#persyaratan-server)
3. [Instalasi](#instalasi)
4. [Konfigurasi](#konfigurasi)
5. [Struktur Modul](#struktur-modul)
6. [Akun & Hak Akses](#akun--hak-akses)
7. [Changelog Fitur](#changelog-fitur)
8. [Riwayat Perbaikan Bug](#riwayat-perbaikan-bug)
9. [Perbaikan Keamanan — 29 Oktober 2026](#perbaikan-keamanan--29-oktober-2026)

---

## Deskripsi Aplikasi

SI-Talenta mengelola siklus lengkap tenaga kerja DLH:

- Pendataan pekerja dan dokumen identitas (KTP, Ijazah)
- Riwayat penugasan dan kontrak kerja (SPT / PKS)
- Generasi dan penomoran Surat Keputusan (SK)
- Laporan dan cetak dokumen resmi
- Manajemen user dan unit kerja

---

## Persyaratan Server

| Komponen        | Versi Minimum                              |
| --------------- | ------------------------------------------ |
| PHP             | 8.1 (direkomendasikan 8.3.36+)             |
| MySQL / MariaDB | 5.7 / 10.3                                 |
| Ekstensi PHP    | `intl`, `mbstring`, `mysqli`, `curl`, `gd` |
| Web Server      | Apache 2.4+ (mod_rewrite aktif)            |

---

## Instalasi

```bash
# 1. Clone atau salin folder ke direktori web
cp -r si-talenta /var/www/html/

# 2. Install dependensi Composer
composer install

# 3. Salin file environment
cp env .env

# 4. Edit .env sesuaikan kredensial
nano .env

# 5. Import skema database
mysql -u root -p db_tenaga_kerja_dlh < app/Database/db_tenaga_kerja_dlh.sql

# 6. Pastikan folder writable dapat ditulis
chmod -R 775 writable/
```

---

## Konfigurasi

Semua konfigurasi utama diset via file `.env` di root project. **Jangan commit file ini.**

```dotenv
CI_ENVIRONMENT = production

app.baseURL = 'https://domain-anda.com/si-talenta/'
app.forceGlobalSecureRequests = true

database.default.hostname = localhost
database.default.database  = db_tenaga_kerja_dlh
database.default.username  = nama_user_db        # JANGAN pakai root di production
database.default.password  = password_kuat
database.default.DBDriver  = MySQLi

encryption.key = hex2bin:...   # generate: php spark key:generate
```

> **Catatan keamanan:** Gunakan user MySQL khusus aplikasi dengan hak akses terbatas (SELECT, INSERT, UPDATE, DELETE pada database aplikasi saja), bukan `root`.

---

## Struktur Modul

| Modul              | Controller      | Akses            |
| ------------------ | --------------- | ---------------- |
| Dashboard          | `Home`          | Semua user login |
| Data Pekerja       | `DataPekerja`   | Semua user login |
| Riwayat Kerja      | `RiwayatKerja`  | Semua user login |
| Penugasan          | `Penugasan`     | Semua user login |
| Laporan / Cetak SK | `Laporan`       | Semua user login |
| Unit Kerja         | `UnitKerja`     | **Admin only**   |
| Daftar Kepala      | `DaftarKepala`  | **Admin only**   |
| Dasar Hukum        | `DasarHukum`    | **Admin only**   |
| List Pekerjaan     | `ListPekerjaan` | **Admin only**   |
| Nomor SK           | `NomorSk`       | **Admin only**   |
| Manajemen User     | `Auth`          | **Admin only**   |

---

## Akun & Hak Akses

Aplikasi memiliki dua level akses:

| Level   | Kemampuan                                                                   |
| ------- | --------------------------------------------------------------------------- |
| `admin` | Akses penuh termasuk master data, manajemen user, dan persetujuan penugasan |
| `user`  | Input data pekerja dan riwayat kerja di unit kerjanya sendiri               |

Login via `/login`. Setelah login, sesi user menyimpan `level`, `id_unit_kerja`, dan data profil.

---

## Changelog Fitur

### v1.2.0 — 29 Oktober 2026

**Perbaikan keamanan menyeluruh** (lihat [bagian lengkapnya](#perbaikan-keamanan--29-oktober-2026)).

---

### v1.1.0 — 12 Januari 2026

**Fitur Baru: Status Pegawai (Percobaan / Aktif)**

Sistem sekarang mendukung dua status pada riwayat kerja pegawai:

| Status    | Durasi                 | Gaji                 |
| --------- | ---------------------- | -------------------- |
| Percobaan | 3 bulan dari TMT Kerja | 80% dari gaji pokok  |
| Aktif     | Tidak terbatas         | 100% dari gaji pokok |

**Perubahan database** — tabel `tb_riwayat_pekerjaan`:

```sql
ALTER TABLE `tb_riwayat_pekerjaan`
  ADD COLUMN `status_pegawai`         ENUM('Percobaan','Aktif') NOT NULL DEFAULT 'Aktif',
  ADD COLUMN `gaji_pokok`             DECIMAL(15,2) NOT NULL DEFAULT 0,
  ADD COLUMN `masa_percobaan_mulai`   DATE NULL,
  ADD COLUMN `masa_percobaan_selesai` DATE NULL;

-- Isi gaji_pokok dari data gaji lama
UPDATE `tb_riwayat_pekerjaan`
SET `gaji_pokok` = CAST(`gaji` AS DECIMAL(15,2))
WHERE `gaji` IS NOT NULL AND `gaji` != '';
```

**File yang diubah:**

- `app/Models/RiwayatKerjaModel.php` — tambah field baru ke `$allowedFields`
- `app/Controllers/RiwayatKerja.php` — `store()` & `update()`: kalkulasi gaji dan masa percobaan otomatis
- `app/Views/riwayat_kerja/add_riwayat_kerja.php` — dropdown status, input gaji pokok, JS kalkulasi otomatis
- `app/Views/riwayat_kerja/edit_riwayat_kerja.php` — tampil nilai existing + kalkulasi
- `app/Views/laporan/cetak_pks_individu.php` — format SK menyesuaikan status
- `app/Views/laporan/cetak_pks.php` — format SK kolektif
- `app/Views/laporan/cetak_spt_individu.php` — format SPT menyesuaikan status
- `app/Views/laporan/cetak_spt.php` — format SPT kolektif

**Cara pakai:**

1. Tambah riwayat kerja → pilih status "Percobaan" → isi gaji pokok → sistem otomatis hitung gaji diterima (80%) dan masa percobaan
2. Setelah masa percobaan selesai → edit riwayat → ubah status ke "Aktif" → gaji otomatis 100%
3. Generate SK — format menyesuaikan status secara otomatis

**Format SK percobaan** mencantumkan: durasi 3 bulan, gaji 80%, tanggal mulai–selesai, dan keterangan gaji penuh setelah lulus.

---

## Riwayat Perbaikan Bug

### Fix: Input Gaji Pokok — 12 Januari 2026

**Masalah:** User bisa input `205.000.000` padahal maksud `2.050.000` karena field bertipe `number`.

**Solusi:** Ubah field gaji pokok ke `type="text"`, tambah JavaScript yang otomatis membersihkan karakter non-digit sebelum simpan. User bisa input dengan atau tanpa titik pemisah ribuan.

**File:** `app/Views/riwayat_kerja/add_riwayat_kerja.php`

---

### Fix: TST Pegawai Percobaan Tidak Sesuai — 12 Januari 2026

**Masalah:** TST (Tanggal Selesai Tugas) pegawai percobaan terisi 31 Desember, padahal harusnya sama dengan tanggal selesai masa percobaan (TMT + 3 bulan).

**Solusi:** Saat status "Percobaan" dipilih, TST otomatis dikunci ke nilai `masa_percobaan_selesai` baik di form (readonly via JS) maupun di controller (di-override sebelum insert).

**File:** `app/Controllers/RiwayatKerja.php`, `app/Views/riwayat_kerja/add_riwayat_kerja.php`

---

### Fix: Tanda Tangan Terpotong saat Cetak SK — 12 Januari 2026

**Masalah:** Page break terjadi di tengah area tanda tangan sehingga tampilan print tidak rapi.

**Solusi:** Tambah CSS `page-break-inside: avoid` pada wrapper `.signature-section` di semua template cetak.

**File:** `cetak_pks.php`, `cetak_pks_individu.php`, `cetak_spt.php`, `cetak_spt_individu.php`

---

### Fix: Multiple Nomor SK dalam Satu Tahun — 12 Januari 2026

**Masalah:** Jika ada lebih dari satu `id_no_sk` dalam satu tahun (misal revisi SK dengan tanggal penetapan berbeda), query `->first()` hanya mengambil record pertama sehingga pegawai yang terikat SK kedua tidak bisa dicetak (nilai `null`).

**Solusi:** Hapus filter berdasarkan `id_no_sk` spesifik. Query langsung berdasarkan `id_pekerja` + `tahun` dengan `orderBy('tanggal_penetapan', 'DESC')` sehingga selalu mengambil SK terbaru terlepas dari nomor urut `id_no_sk`.

**File:** `app/Controllers/Laporan.php` — method `cetak_pks()` dan `cetak_pks_individu()`

---

## Perbaikan Keamanan — 29 Oktober 2026

Audit keamanan menyeluruh dilakukan pada 29 Oktober 2026. Berikut adalah daftar lengkap celah yang ditemukan dan perbaikan yang diterapkan.

---

### Status PHP & Framework

| Komponen    | Versi  | Status                                                                 |
| ----------- | ------ | ---------------------------------------------------------------------- |
| PHP         | 8.3.36 | ✅ Aman — sudah menambal CVE-2026-109618 & CVE-2026-109619 (PHP2Shell) |
| CodeIgniter | 4.6.1  | ⚠️ Versi terbaru 4.7.5+, direkomendasikan upgrade                      |

**CVE terkait CodeIgniter yang terdampak sebagian:**

| CVE            | Deskripsi                                 | Dampak pada app ini                                 |
| -------------- | ----------------------------------------- | --------------------------------------------------- |
| CVE-2026-63223 | Bypass validasi `ext_in`/`is_image` → RCE | Sedang — `ext_in` dipakai di beberapa upload        |
| CVE-2026-63222 | Path traversal `UploadedFile::move()`     | Rendah — semua `move()` sudah memakai nama acak     |
| CVE-2026-63221 | SQLi via `deleteBatch()`                  | Tidak terdampak — app tidak memakai `deleteBatch()` |
| CVE-2026-63220 | Spoof `X-Forwarded-Proto` bypass HTTPS    | Sedang — diatasi dengan fix baseURL                 |
| CVE-2025-54418 | RCE ImageMagick handler (CVSS 9.8)        | Tidak terdampak — app memakai GD, bukan imagick     |

---

### FIX-SEC-01 — CSRF Protection Diaktifkan

**Severity:** Critical

**Masalah:** Filter `csrf` terdaftar di `Filters.php` tetapi tidak pernah dipasang ke `$globals`, sehingga **semua POST tidak terlindungi** dari serangan Cross-Site Request Forgery.

**Perbaikan:**

- `app/Config/Filters.php` — tambah `'csrf'` ke `$globals['before']`
- `app/Config/Filters.php` — aktifkan `honeypot` dan `secureheaders` di `$globals['after']`
- `app/Views/dashboard/main.php` — tambah `<meta name="csrf-token">` di `<head>` dan setup `$.ajaxSetup` agar semua AJAX otomatis kirim header `X-CSRF-TOKEN`
- Semua 18 file view yang memiliki `<form method="POST">` ditambah `<?= csrf_field() ?>`
- `app/Config/Security.php` — ubah `$regenerate = false` agar token stabil per-session (tidak regenerasi per submit, menghindari race condition pada AJAX)

**File yang diubah:** `app/Config/Filters.php`, `app/Config/Security.php`, `app/Views/dashboard/main.php`, dan 18 file view.

---

### FIX-SEC-02 — Delete via GET Diubah ke POST

**Severity:** Critical

**Masalah:** Semua route hapus data menggunakan `GET`, sehingga cukup satu tag `<img src="/data_pekerja/delete/123">` di halaman lain untuk menghapus data korban yang sedang login.

**Perbaikan:**

- `app/Config/Routes.php` — semua route `delete` diubah dari `$routes->get()` menjadi `$routes->post()`
- Semua tombol hapus di view diubah dari `<a href>` menjadi `<form method="post">` dengan `csrf_field()` di dalamnya

**Route yang diubah:**

```
data_pekerja/delete   GET → POST
unit_kerja/delete     GET → POST
daftar_kepala/delete  GET → POST
list_pekerjaan/delete GET → POST
dasar_hukum/delete    GET → POST
no-sk/delete          GET → POST
```

**File yang diubah:** `app/Config/Routes.php`, `data_pekerja.php`, `unit_kerja.php`, `list_pekerjaan.php`, `daftar_kepala.php`, `dasar_hukum.php`, `no_sk.php`, `user.php`

---

### FIX-SEC-03 — Privilege Escalation pada register() dan update_user()

**Severity:** Critical

**Masalah:** Method `Auth::register()` dan `Auth::update_user()` tidak memeriksa level user yang sedang login. Akibatnya user level apapun bisa membuat akun baru dengan `level=admin` atau mempromosikan akun dirinya sendiri.

**Perbaikan:**

- `Auth::register()` — tambah guard `if (session()->get('level') !== 'admin') return redirect()` di awal method
- `Auth::update_user()` — tambah guard yang sama, dengan pengecualian untuk edit profil sendiri (hanya field non-sensitif)
- Field `level` dan `status` dikunci ke nilai lama saat yang melakukan edit bukan admin (`$isProfileEdit`)

**File yang diubah:** `app/Controllers/Auth.php`

---

### FIX-SEC-04 — Unrestricted File Upload → RCE

**Severity:** Critical

**Masalah:** `RiwayatKerja::upload()` menerima file apa pun tanpa validasi ekstensi atau MIME type. File disimpan ke `public/uploads/` yang tidak ada `.htaccess` pemblokir PHP, sehingga webshell `.php` yang diunggah bisa dieksekusi langsung via URL.

**Perbaikan:**

- `app/Controllers/RiwayatKerja.php` — tambah validasi `ext_in[fileUpload,pdf]|mime_in[fileUpload,application/pdf]|max_size[fileUpload,2048]`
- Nama file diganti dari `getRandomName()` (mempertahankan ekstensi asli) menjadi `bin2hex(random_bytes(16)) . '.pdf'` (ekstensi dipaksa `.pdf`)
- `public/uploads/.htaccess` — dibuat baru, memblokir eksekusi semua file script (`.php`, `.phtml`, `.phar`, `.cgi`, dll.) dan menonaktifkan directory listing

**File yang diubah:** `app/Controllers/RiwayatKerja.php`, `public/uploads/.htaccess` _(file baru)_

---

### FIX-SEC-05 — IDOR pada Endpoint RiwayatKerja

**Severity:** High

**Masalah:** Method `hapus()`, `upload()`, `input_gaji_uraian()`, dan `getGajiUraian()` menerima ID numerik dari POST tanpa memeriksa apakah record tersebut milik unit kerja user yang sedang login. Siapapun yang login bisa memanipulasi data riwayat unit lain.

**Perbaikan:**

- Tambah private method `isAuthorizedForRiwayat(array $riwayat): bool` yang membandingkan `$riwayat['id_unit_kerja']` dengan `session()->get('id_unit_kerja')`. Admin selalu diizinkan.
- Semua 4 method di atas dipanggil pengecekan ini sebelum melakukan aksi apapun.

**File yang diubah:** `app/Controllers/RiwayatKerja.php`

---

### FIX-SEC-06 — Broken Access Control pada Master Data

**Severity:** High

**Masalah:** CRUD master data (Unit Kerja, Daftar Kepala, Dasar Hukum, List Pekerjaan, Nomor SK) hanya dilindungi filter `login` tanpa cek role, sehingga user biasa bisa mengubah data yang seharusnya eksklusif admin.

**Perbaikan:**

- `app/Filters/AdminFilter.php` — dibuat filter baru yang memblokir akses jika `session()->get('level') !== 'admin'`
- `app/Config/Filters.php` — daftarkan alias `'admin'` untuk filter baru
- `app/Config/Routes.php` — 5 grup route master data dibungkus `$routes->group('', ['filter' => 'admin'], ...)` sehingga seluruh route di dalamnya otomatis dijaga

**Route yang dijaga admin:**

```
/unit_kerja (semua method)
/daftar_kepala (semua method)
/list_pekerjaan (semua method)
/dasar_hukum (semua method)
/no-sk (semua method)
```

**File yang diubah:** `app/Filters/AdminFilter.php` _(file baru)_, `app/Config/Filters.php`, `app/Config/Routes.php`

---

### FIX-SEC-07 — Session Fixation

**Severity:** High

**Masalah:** Setelah login berhasil, `session()->regenerate()` tidak dipanggil sehingga attacker yang berhasil menanam session ID ke browser korban bisa mengambil alih sesi.

**Perbaikan:**

- `Auth::login()` — tambah `session()->regenerate(true)` sebelum `session()->set()`

**File yang diubah:** `app/Controllers/Auth.php`

---

### FIX-SEC-08 — Stored XSS via Output View Tidak Di-escape

**Severity:** High

**Masalah:** View tabel menampilkan data dari database menggunakan `<?= $row['field'] ?>` tanpa `esc()`. CI4 PHP view renderer tidak auto-escape. Field yang bisa diedit user (nama, nomor, uraian) berpotensi diisi script `<script>alert(1)</script>` yang dieksekusi di browser admin.

**Perbaikan:**

- Script otomatis menambah `esc()` ke semua output `<?= $var['field'] ?>` yang belum di-escape pada file view tabel

**File yang diubah:** `dasar_hukum.php`, `unit_kerja.php`, `list_pekerjaan.php`, `daftar_kepala.php`, `data_pekerja.php`, `penugasan/daftar_penugasan.php`

---

### FIX-SEC-09 — baseURL Dinamis dari HTTP_HOST

**Severity:** High

**Masalah:** Konstruktor `App.php` membangun `baseURL` dari `$_SERVER['HTTP_HOST']` yang dikontrol user/attacker. Ini memungkinkan host header injection yang bisa memanipulasi link dan redirect yang dihasilkan aplikasi.

**Perbaikan:**

- `app/Config/App.php` — hapus logika dinamis, `baseURL` kini hanya menggunakan nilai dari `.env`. Jika `.env` kosong, fallback ke `http://localhost/si-talenta/`.

**File yang diubah:** `app/Config/App.php`

---

### FIX-SEC-10 — DBDebug Aktif di Production

**Severity:** Medium

**Masalah:** `'DBDebug' => true` di `Database.php` menyebabkan error database mentah (termasuk nama tabel dan struktur query) ditampilkan ke user di production.

**Perbaikan:**

- `app/Config/Database.php` — ubah nilai menjadi `(ENVIRONMENT !== 'production')` sehingga debug aktif hanya di environment development/testing.

**File yang diubah:** `app/Config/Database.php`

---

### FIX-SEC-11 — Secure Headers & Honeypot Diaktifkan

**Severity:** Medium

**Masalah:** Filter `secureheaders` dan `honeypot` sudah terdaftar tapi dikomentari di `$globals['after']`.

**Perbaikan:**

- `app/Config/Filters.php` — aktifkan keduanya di `$globals['after']`. `secureheaders` otomatis menambah header `X-Content-Type-Options`, `X-Frame-Options`, `Referrer-Policy`, dll. `honeypot` mendeteksi bot yang mengisi field tersembunyi.

**File yang diubah:** `app/Config/Filters.php`

---

### FIX-SEC-12 — Brute Force Login & Username Enumeration

**Severity:** Medium

**Masalah:** `Auth::login()` tidak ada pembatasan percobaan. Pesan error berbeda antara "User is not active" dan "Invalid username or password" memungkinkan attacker mendeteksi username yang valid.

**Perbaikan:**

- `Auth::login()` — tambah rate limiter CI4 (`Services::throttler()`) dengan batas 5 percobaan per 5 menit per IP
- Pesan error disamakan menjadi satu pesan generik: _"Username atau password salah, atau akun tidak aktif."_

**File yang diubah:** `app/Controllers/Auth.php`

---

### Ringkasan File yang Diubah pada 29 Oktober 2026

| File                               | Perubahan                                                                                      |
| ---------------------------------- | ---------------------------------------------------------------------------------------------- |
| `app/Config/Filters.php`           | CSRF aktif global, AdminFilter didaftarkan, secureheaders + honeypot aktif                     |
| `app/Config/Routes.php`            | 6 route delete GET→POST, 5 grup master data dibungkus filter admin                             |
| `app/Config/App.php`               | baseURL tidak lagi dari HTTP_HOST                                                              |
| `app/Config/Security.php`          | `$regenerate = false`                                                                          |
| `app/Config/Database.php`          | `DBDebug` off di production                                                                    |
| `app/Controllers/Auth.php`         | Guard admin di register/update_user, session regenerate, rate limit login, pesan error seragam |
| `app/Controllers/RiwayatKerja.php` | Validasi upload PDF, IDOR check via isAuthorizedForRiwayat()                                   |
| `app/Filters/AdminFilter.php`      | **File baru** — filter blokir non-admin                                                        |
| `public/uploads/.htaccess`         | **File baru** — blokir eksekusi script di folder upload                                        |
| `app/Views/dashboard/main.php`     | Meta CSRF token + $.ajaxSetup header                                                           |
| `app/Views/auth/login.php`         | csrf_field() di form login                                                                     |
| 17 file view lainnya               | csrf_field() di semua form POST, delete link diubah ke POST form, esc() di output tabel        |

---

## Lisensi

MIT License. Lihat file `LICENSE` untuk detail lengkap.

---

## Dokumentasi Teknis

Dokumentasi teknis per fitur tersedia di folder `docs/`:

| File                               | Isi                                                   |
| ---------------------------------- | ----------------------------------------------------- |
| `docs/IMPLEMENTASI_SWEETALERT2.md` | Cara kerja, integrasi, dan panduan extend SweetAlert2 |
