# Fitur Status Pegawai (Percobaan/Aktif)

## Deskripsi

Fitur ini menambahkan status pegawai untuk membedakan antara pegawai dalam **masa percobaan** dan pegawai **aktif**:

- **Status Percobaan**:
  - Durasi: 3 bulan dari TMT Kerja
  - Gaji: 80% dari gaji pokok
  - Informasi masa percobaan (mulai dan selesai) ditampilkan di SK
- **Status Aktif**:
  - Gaji: 100% dari gaji pokok
  - Tidak ada masa percobaan

## Perubahan Database

### Tabel: `tb_riwayat_pekerjaan`

Field baru yang ditambahkan:

| Field                    | Type                       | Default | Keterangan                                          |
| ------------------------ | -------------------------- | ------- | --------------------------------------------------- |
| `status_pegawai`         | ENUM('Percobaan', 'Aktif') | 'Aktif' | Status pegawai (percobaan/aktif)                    |
| `gaji_pokok`             | DECIMAL(15,2)              | 0       | Gaji pokok 100%                                     |
| `masa_percobaan_mulai`   | DATE                       | NULL    | Tanggal mulai masa percobaan                        |
| `masa_percobaan_selesai` | DATE                       | NULL    | Tanggal selesai masa percobaan (3 bulan dari mulai) |

**Note**: Field `gaji` yang sudah ada akan menjadi gaji yang diterima (80% atau 100% tergantung status)

## Cara Menjalankan Migration

```bash
# Jalankan query SQL di database
mysql -u [user] -p [database_name] < app/Database/migrations/add_status_pegawai_to_riwayat.sql
```

Atau copy paste isi file SQL ke phpMyAdmin / MySQL client

## Fitur yang Diupdate

### 1. Form Input Riwayat Kerja (`add_riwayat_kerja.php`)

- Menambahkan dropdown **Status Pegawai** (Percobaan/Aktif)
- Field **Gaji Pokok** (gaji 100%)
- Display **Gaji Yang Diterima** (dihitung otomatis: 80% atau 100%)
- Info **Masa Percobaan** (ditampilkan jika status Percobaan)
- JavaScript untuk kalkulasi otomatis

### 2. Form Edit Riwayat Kerja (`edit_riwayat_kerja.php`)

- Sama seperti form input
- Menampilkan nilai existing dari database

### 3. Controller RiwayatKerja

- **Method `store()`**:
  - Validasi status_pegawai
  - Kalkulasi gaji berdasarkan status (80% atau 100%)
  - Kalkulasi masa percobaan (3 bulan) jika status Percobaan
- **Method `update()`**:
  - Update validasi untuk gaji_pokok
  - Kalkulasi ulang gaji dan masa percobaan

### 4. Model RiwayatKerjaModel

- Update `$allowedFields` untuk menambahkan field baru

### 5. Template SK (Surat Keputusan)

File yang diupdate:

- `cetak_pks_individu.php` - PKS individu
- `cetak_pks.php` - PKS kolektif/massal
- `cetak_spt_individu.php` - SPT individu
- `cetak_spt.php` - SPT kolektif/massal

**Format SK untuk Percobaan**:

```
- PIHAK KEDUA berstatus MASA PERCOBAAN selama 3 (tiga) bulan
  terhitung mulai tanggal [TMT] sampai dengan [TMT + 3 bulan]
- Selama masa percobaan, PIHAK KEDUA berhak menerima upah
  sebesar 80% (delapan puluh persen) dari gaji pokok yaitu
  Rp. [gaji_80%] dari gaji pokok Rp. [gaji_pokok]
- Setelah masa percobaan selesai dan dinyatakan lulus,
  PIHAK KEDUA akan menerima upah penuh sebesar 100%
```

**Format SK untuk Aktif**:

```
- PIHAK KEDUA berhak menerima upah dari PIHAK KESATU
  sebesar Rp. [gaji] perbulan
```

## Penggunaan

### Input Pegawai Baru dengan Status Percobaan

1. Buka form **Tambah Riwayat Kerja**
2. Pilih **Status Pegawai**: "Percobaan (3 Bulan, Gaji 80%)"
3. Masukkan **Gaji Pokok** (contoh: 2.000.000)
4. Sistem akan otomatis:
   - Menghitung gaji yang diterima = 1.600.000 (80%)
   - Menghitung masa percobaan mulai = TMT Kerja
   - Menghitung masa percobaan selesai = TMT Kerja + 3 bulan
5. Simpan data

### Mengubah Status dari Percobaan ke Aktif

Setelah masa percobaan selesai dan pegawai dinyatakan lulus:

1. Edit riwayat kerja pegawai tersebut
2. Ubah **Status Pegawai** dari "Percobaan" menjadi "Aktif"
3. Gaji akan otomatis berubah menjadi 100% dari gaji pokok
4. Masa percobaan akan dihapus (NULL)
5. Simpan perubahan

### Generate SK

SK akan otomatis menyesuaikan format berdasarkan status pegawai:

- Jika **Percobaan**: Format SK mencantumkan masa percobaan dan gaji 80%
- Jika **Aktif**: Format SK standar dengan gaji 100%

## Catatan Penting

1. **Data Existing**:
   - Setelah migration, semua data lama akan memiliki `status_pegawai = 'Aktif'`
   - Field `gaji_pokok` akan diisi dengan nilai dari field `gaji`
   - Tidak ada perubahan pada SK yang sudah dicetak sebelumnya

2. **Backward Compatibility**:
   - Sistem menggunakan fallback `$pekerja['gaji_pokok'] ?? $pekerja['gaji']`
   - Jika field baru tidak ada, akan menggunakan nilai gaji existing

3. **Validasi**:
   - Status pegawai wajib dipilih
   - Gaji pokok wajib diisi dan berupa angka

## Testing

Untuk testing fitur ini:

1. Tambah pegawai baru dengan status "Percobaan"
2. Cek apakah gaji dihitung 80% dari gaji pokok
3. Cek apakah masa percobaan dihitung 3 bulan dari TMT
4. Generate SK dan cek format SK
5. Edit status menjadi "Aktif" dan cek apakah gaji berubah 100%
6. Generate SK lagi dan cek format SK berubah

## Troubleshooting

**Q: Gaji tidak terhitung otomatis di form?**
A: Pastikan JavaScript tidak error, check console browser (F12)

**Q: Format SK tidak berubah?**
A: Pastikan field `status_pegawai` ada di query database

**Q: Migration gagal?**
A: Cek apakah tabel `tb_riwayat_pekerjaan` ada dan struktur sesuai

## Developer

Dibuat pada: 12 Januari 2026
Fitur: Status Pegawai (Percobaan/Aktif) dengan Kalkulasi Gaji Otomatis
