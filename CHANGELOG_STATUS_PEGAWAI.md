# Changelog - Fitur Status Pegawai

## Versi 1.1.0 - 12 Januari 2026

### 🎉 Fitur Baru: Status Pegawai (Percobaan/Aktif)

Sistem sekarang mendukung status pegawai dengan 2 kategori:

#### 📋 **Status Percobaan**

- ⏱️ Masa percobaan: **3 bulan** dari TMT Kerja
- 💰 Gaji: **80%** dari gaji pokok
- 📄 SK otomatis mencantumkan informasi masa percobaan
- 📅 Tanggal mulai dan selesai masa percobaan dihitung otomatis

#### ✅ **Status Aktif**

- 💰 Gaji: **100%** dari gaji pokok
- 📄 SK dengan format standar
- Tidak ada batasan masa percobaan

---

### 📝 Perubahan yang Dilakukan

#### 1. Database

- ✅ Tambah field `status_pegawai` (Percobaan/Aktif)
- ✅ Tambah field `gaji_pokok` (gaji 100%)
- ✅ Tambah field `masa_percobaan_mulai` (tanggal mulai)
- ✅ Tambah field `masa_percobaan_selesai` (tanggal selesai)
- ✅ Field `gaji` existing menjadi gaji yang diterima

#### 2. Form Input & Edit Riwayat Kerja

- ✅ Dropdown **Status Pegawai** (wajib pilih)
- ✅ Input **Gaji Pokok** (gaji 100%)
- ✅ Display **Gaji Yang Diterima** (kalkulasi otomatis)
- ✅ Info **Masa Percobaan** (muncul jika status Percobaan)
- ✅ Kalkulasi otomatis menggunakan JavaScript

#### 3. Template SK (Surat Keputusan)

- ✅ Format SK PKS (Perjanjian Kerja Sama) - Individu & Kolektif
- ✅ Format SK SPT (Surat Perintah Tugas) - Individu & Kolektif
- ✅ Otomatis menyesuaikan format berdasarkan status pegawai

---

### 🚀 Cara Menggunakan

#### **Menambah Pegawai Baru dengan Status Percobaan**

1. Buka menu **Riwayat Kerja** → **Tambah Riwayat Kerja**
2. Isi data pekerjaan seperti biasa
3. Pilih **Status Pegawai**: `Percobaan (3 Bulan, Gaji 80%)`
4. Masukkan **Gaji Pokok**: Contoh `2.000.000`
5. Sistem otomatis menghitung:
   - **Gaji Diterima**: `1.600.000` (80%)
   - **Masa Percobaan Mulai**: Sama dengan TMT Kerja
   - **Masa Percobaan Selesai**: TMT + 3 bulan
6. Klik **Simpan**

#### **Mengubah Status dari Percobaan ke Aktif**

Setelah masa percobaan selesai (3 bulan):

1. Buka menu **Riwayat Kerja** pegawai yang bersangkutan
2. Klik **Edit** pada riwayat kerja
3. Ubah **Status Pegawai** menjadi `Aktif (Gaji 100%)`
4. Gaji otomatis berubah menjadi 100% dari gaji pokok
5. Klik **Simpan**

#### **Generate SK**

SK akan otomatis menyesuaikan format:

- **Jika Percobaan**:

  ```
  ✓ Mencantumkan status "MASA PERCOBAAN"
  ✓ Durasi 3 bulan
  ✓ Gaji 80% dari gaji pokok
  ✓ Tanggal mulai dan selesai
  ✓ Informasi gaji 100% setelah lulus
  ```

- **Jika Aktif**:
  ```
  ✓ Format SK standar
  ✓ Gaji 100%
  ✓ Tidak ada keterangan masa percobaan
  ```

---

### 📊 Contoh Skenario

**Contoh 1: Pegawai Baru Masa Percobaan**

- TMT Kerja: 1 Januari 2026
- Gaji Pokok: Rp 2.500.000
- Status: Percobaan
- **Hasil**:
  - Gaji Diterima: Rp 2.000.000 (80%)
  - Masa Percobaan: 1 Jan 2026 - 1 Apr 2026
  - SK mencantumkan informasi lengkap masa percobaan

**Contoh 2: Pegawai Lulus Masa Percobaan**

- Masa Percobaan Selesai: 1 April 2026
- Evaluasi: LULUS
- **Action**:
  - Edit riwayat kerja
  - Ubah status menjadi "Aktif"
  - Gaji otomatis menjadi Rp 2.500.000 (100%)
  - Generate SK baru dengan format aktif

---

### ⚠️ Catatan Penting

1. **Data Lama Aman**
   - Semua data pegawai lama otomatis berstatus "Aktif"
   - Gaji pokok = gaji yang sudah ada
   - SK lama tidak berubah

2. **Validasi**
   - Status pegawai wajib dipilih
   - Gaji pokok wajib diisi (tidak boleh kosong)
   - Gaji pokok harus berupa angka

3. **Kalkulasi Otomatis**
   - Gaji dihitung otomatis saat input
   - Masa percobaan dihitung otomatis (3 bulan dari TMT)
   - Jika ubah status, gaji otomatis berubah

4. **Format SK**
   - SK otomatis menyesuaikan format berdasarkan status
   - Tidak perlu edit manual template SK

---

### 🐛 Troubleshooting

**Q: Gaji tidak terhitung otomatis?**

- Pastikan JavaScript browser aktif
- Cek console browser (tekan F12)
- Refresh halaman dan coba lagi

**Q: Masa percobaan tidak muncul?**

- Pastikan status dipilih "Percobaan"
- Pastikan TMT Kerja sudah diisi
- Refresh form jika perlu

**Q: Format SK tidak sesuai?**

- Pastikan data riwayat kerja sudah disimpan
- Generate ulang SK
- Cek status pegawai di database

**Q: Error saat simpan data?**

- Pastikan semua field wajib sudah diisi
- Cek validasi error di halaman
- Hubungi admin jika masalah berlanjut

---

### 📞 Kontak Support

Jika ada pertanyaan atau kendala terkait fitur ini, silakan hubungi:

- **Admin Sistem**: [kontak admin]
- **IT Support**: [kontak IT]

---

### 📚 Dokumentasi Lengkap

Dokumentasi teknis lengkap tersedia di:
`app/Database/migrations/README_STATUS_PEGAWAI.md`
