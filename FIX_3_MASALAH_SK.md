# Fix 3 Masalah pada Sistem SK

## 📋 Overview

Dokumen ini menjelaskan 3 perbaikan yang telah dilakukan pada sistem:

1. ✅ **Gaji Pokok Terlalu Besar** (205.000.000 → harusnya 2.050.000)
2. ✅ **Masa Berlaku SPK untuk Percobaan** (TST harus = masa_percobaan_selesai)
3. ✅ **Tanda Tangan Terpotong** (Page break tidak sempurna)

---

## 1️⃣ FIX: Gaji Pokok Terlalu Besar

### 🐛 Masalah

User input gaji pokok **205.000.000** (seharusnya **2.050.000**).
Kemungkinan user salah input atau salah format.

### ✅ Solusi

#### A. Update Form Input - Ubah ke Text Input

**File**: `app/Views/riwayat_kerja/add_riwayat_kerja.php`

```html
<!-- BEFORE: type="number" -->
<input
  type="number"
  class="form-control"
  id="input_gaji_pokok"
  name="gaji_pokok"
/>

<!-- AFTER: type="text" dengan validasi JavaScript -->
<input
  type="text"
  class="form-control"
  id="input_gaji_pokok"
  name="gaji_pokok"
  placeholder="Contoh: 2050000"
/>
<small class="form-text text-muted">
  <strong>Format:</strong> Angka saja tanpa titik/koma. Contoh: 2050000 untuk Rp
  2.050.000
</small>
```

#### B. Update JavaScript - Auto Clean Input

**File**: `app/Views/riwayat_kerja/add_riwayat_kerja.php`

```javascript
function hitungGajiDiterima() {
  let gajiPokokInput = document.getElementById("input_gaji_pokok").value;

  // ✅ Hapus semua karakter non-digit (titik, koma, dll)
  gajiPokokInput = gajiPokokInput.replace(/\D/g, "");

  const gajiPokok = parseFloat(gajiPokokInput) || 0;

  // Update input dengan nilai yang sudah dibersihkan
  if (gajiPokokInput) {
    document.getElementById("input_gaji_pokok").value = gajiPokokInput;
  }

  // ... kalkulasi gaji diterima
}
```

### 🎯 Hasil

- ✅ Input otomatis dibersihkan dari titik/koma
- ✅ User bisa input: `2.050.000` atau `2050000` → tersimpan sebagai `2050000`
- ✅ Tampilan gaji diterima tetap format Rupiah: `Rp 1.640.000`

---

## 2️⃣ FIX: Masa Berlaku SPK untuk Percobaan

### 🐛 Masalah

Pegawai dengan status **Percobaan**:

- TMT: 09 Juli 2026
- Masa Percobaan: 3 bulan (09 Juli - 09 Oktober 2026)
- **TST saat ini**: 31 Desember 2026 ❌ (SALAH)
- **TST yang benar**: 09 Oktober 2026 ✅

**Konsep**:

- Pegawai percobaan **hanya 3 bulan**
- Setelah lulus, buat SPK baru dengan status **Aktif** dan gaji **100%**

### ✅ Solusi

#### A. Update Controller Store - Auto Set TST

**File**: `app/Controllers/RiwayatKerja.php` - Method `store()`

```php
// Hitung masa percobaan jika status pegawai adalah Percobaan
$masaPercobaanMulai = null;
$masaPercobaanSelesai = null;
$tstKerja = date('Y-m-d', strtotime($this->request->getVar('tst_kerja')));

if ($statusPegawai == 'Percobaan') {
    $masaPercobaanMulai = $tmtBaru;
    // Masa percobaan 3 bulan dari TMT
    $masaPercobaanSelesai = date('Y-m-d', strtotime($tmtBaru . ' +3 months'));

    // ✅ PENTING: TST Kerja untuk percobaan = masa_percobaan_selesai
    $tstKerja = $masaPercobaanSelesai;
}

$data = [
    // ...
    'tmt_kerja' => $tmtBaru,
    'tst_kerja' => $tstKerja, // ← TST otomatis = masa percobaan selesai
    'masa_percobaan_mulai' => $masaPercobaanMulai,
    'masa_percobaan_selesai' => $masaPercobaanSelesai,
    // ...
];
```

#### B. Update Controller Update

**File**: `app/Controllers/RiwayatKerja.php` - Method `update()`

```php
// Sama seperti store
if ($statusPegawai == 'Percobaan') {
    $masaPercobaanMulai = $this->request->getVar('tmt_kerja');
    $masaPercobaanSelesai = date('Y-m-d', strtotime($masaPercobaanMulai . ' +3 months'));

    // ✅ TST = masa percobaan selesai
    $tstKerja = $masaPercobaanSelesai;
}
```

#### C. Update Form - Auto Set TST & Readonly

**File**: `app/Views/riwayat_kerja/add_riwayat_kerja.php`

```html
<div class="form-group">
  <label for="input_tst">TST Kerja</label>
  <input
    type="date"
    class="form-control"
    id="input_tst"
    name="tst_kerja"
    required
  />
  <small class="form-text text-muted" id="info_tst">
    <span id="info_tst_percobaan" style="display:none;" class="text-warning">
      <i class="mdi mdi-alert-circle"></i>
      Untuk pegawai percobaan, TST akan otomatis disesuaikan dengan masa
      percobaan selesai (3 bulan)
    </span>
  </small>
</div>
```

**JavaScript**:

```javascript
function hitungMasaPercobaan() {
  const tmtKerja = document.getElementById("input_tmt").value;
  const tstInput = document.getElementById("input_tst");

  if (tmtKerja) {
    const tmtDate = new Date(tmtKerja);
    const selesaiDate = new Date(tmtDate);
    selesaiDate.setMonth(selesaiDate.getMonth() + 3);

    // Format tanggal untuk input date (YYYY-MM-DD)
    const selesaiFormatted = selesaiDate.toISOString().split("T")[0];

    // ✅ Set TST otomatis = masa percobaan selesai
    tstInput.value = selesaiFormatted;
    tstInput.readOnly = true; // Readonly untuk percobaan
    infoTstPercobaan.style.display = "inline";
  }
}

function updateTstStatus() {
  const statusPegawai = document.getElementById("input_status_pegawai").value;
  const tstInput = document.getElementById("input_tst");

  if (statusPegawai === "Percobaan") {
    hitungMasaPercobaan(); // Auto calculate TST
  } else {
    tstInput.readOnly = false; // Bisa input manual untuk Aktif
    infoTstPercobaan.style.display = "none";
  }
}
```

### 🎯 Hasil

**Skenario Percobaan**:

```
Input:
- Status: Percobaan
- TMT: 09 Juli 2026

Output (Auto):
- Masa Percobaan Mulai: 09 Juli 2026
- Masa Percobaan Selesai: 09 Oktober 2026
- TST Kerja: 09 Oktober 2026 ✅ (Auto set, readonly)
- Gaji: 80% dari gaji pokok
```

**Skenario Aktif**:

```
Input:
- Status: Aktif
- TMT: 09 Juli 2026

Output:
- TST Kerja: Bisa input manual (misal 31 Des 2026) ✅
- Gaji: 100% dari gaji pokok
- Tidak ada masa percobaan
```

**Workflow Setelah Lulus Percobaan**:

1. Pegawai percobaan masa kerja habis (09 Oktober 2026)
2. Jika LULUS → **Buat riwayat kerja BARU**:
   - Status: **Aktif**
   - TMT: 10 Oktober 2026
   - TST: 31 Desember 2026 (atau sesuai kebutuhan)
   - Gaji: **100%**
3. Generate SK baru dengan format SK Aktif

---

## 3️⃣ FIX: Tanda Tangan Terpotong

### 🐛 Masalah

Saat cetak SK, **tanda tangan terpotong** karena page break terjadi di tengah-tengah area tanda tangan.

### ✅ Solusi

Tambahkan CSS `page-break-inside: avoid` dan wrapper class `signature-section` untuk semua template SK.

#### A. Update PKS Individu

**File**: `app/Views/laporan/cetak_pks_individu.php`

**CSS**:

```css
@media print {
  .page-break {
    page-break-before: always;
  }

  /* Hindari page break di tengah elemen penting */
  .pasal,
  .lingkup,
  table {
    page-break-inside: avoid;
  }

  /* ✅ Pastikan tanda tangan tidak terpotong */
  .signature-section {
    page-break-inside: avoid;
    margin-top: 30px;
    min-height: 200px; /* Minimal tinggi untuk tanda tangan */
  }
}

.signature-section {
  margin-top: 30px;
  padding-top: 20px;
}
```

**HTML**:

```html
<p>Demikian Perjanjian Kerja Waktu Tertentu ini dibuat...</p>

<!-- ✅ Wrap tabel tanda tangan dengan div signature-section -->
<div class="signature-section">
  <table style="width:100%; margin-top: 0px;">
    <tr>
      <td style="text-align:center;width: 50%;">
        PIHAK KESATU<br /><br /><br /><br /><br /><br />
        <u><?= esc($kepala['nama_kepala']) ?></u><br />
        NIP. <?= esc($kepala['nip']) ?><br />
      </td>
      <td style="text-align:center; width: 50%;">
        PIHAK KEDUA<br /><br /><br /><br /><br /><br />
        <?= strtoupper($pekerja['nama']) ?><br />
        &nbsp;
      </td>
    </tr>
  </table>
</div>
```

#### B. Update PKS Kolektif

**File**: `app/Views/laporan/cetak_pks.php`

Sama seperti PKS Individu:

- Tambah CSS `signature-section`
- Wrap tabel tanda tangan dengan `<div class="signature-section">`

#### C. Update SPT Individu

**File**: `app/Views/laporan/cetak_spt_individu.php`

**CSS**:

```css
@media print {
  /* ✅ Pastikan tanda tangan tidak terpotong */
  .signature-section {
    page-break-inside: avoid;
    margin-top: 30px;
    min-height: 150px; /* SPT lebih kecil dari PKS */
  }
}

.signature-section {
  margin-top: 30px;
  padding-top: 20px;
}
```

**HTML**:

```html
<!-- ✅ Wrap area tanda tangan dengan div signature-section -->
<div class="signature-section">
  <div class="d-flex justify-content-end">
    <div style="width: 400px;">
      <p class="mb-0 ms-5">Ditetapkan di Pekalongan</p>
      <p class="mb-2 ms-5">Pada Tanggal : ...</p>
      <div class="text-center">
        <strong
          >KEPALA DINAS LINGKUNGAN HIDUP<br />
          KOTA PEKALONGAN</strong
        >
        <br /><br /><br />
        <div class="fw-bold">
          <u><?= esc($kepala['nama_kepala']) ?></u>
        </div>
        <div>NIP. <?= esc($kepala['nip']) ?></div>
      </div>
    </div>
  </div>
</div>
```

#### D. Update SPT Kolektif

**File**: `app/Views/laporan/cetak_spt.php`

Sama seperti SPT Individu.

### 🎯 Hasil

- ✅ Tanda tangan **tidak akan terpotong** saat print
- ✅ Jika area tanda tangan mendekati akhir halaman, **otomatis pindah ke halaman baru**
- ✅ Layout tetap rapi dan profesional

---

## 📝 File yang Diubah

### 1. Controller

- ✅ `app/Controllers/RiwayatKerja.php`
  - Method `store()` → Auto set TST untuk percobaan
  - Method `update()` → Auto set TST untuk percobaan

### 2. View Form

- ✅ `app/Views/riwayat_kerja/add_riwayat_kerja.php`
  - Input gaji pokok: `type="text"` + validasi JS
  - Input TST: Auto set + readonly untuk percobaan
  - JavaScript: `hitungGajiDiterima()`, `hitungMasaPercobaan()`, `updateTstStatus()`

### 3. View Template SK

- ✅ `app/Views/laporan/cetak_pks_individu.php`
  - CSS: `.signature-section`
  - HTML: Wrap tanda tangan dengan `<div class="signature-section">`

- ✅ `app/Views/laporan/cetak_pks.php`
  - CSS: `.signature-section`
  - HTML: Wrap tanda tangan dengan `<div class="signature-section">`

- ✅ `app/Views/laporan/cetak_spt_individu.php`
  - CSS: `.signature-section`
  - HTML: Wrap tanda tangan dengan `<div class="signature-section">`

- ✅ `app/Views/laporan/cetak_spt.php`
  - CSS: `.signature-section`
  - HTML: Wrap tanda tangan dengan `<div class="signature-section">`

---

## 🧪 Testing

### Test Case 1: Input Gaji Pokok

```
Input: 2.050.000
Expected: Tersimpan sebagai 2050000 ✅
Display: Rp 1.640.000 (80% jika percobaan) ✅
```

### Test Case 2: Pegawai Percobaan

```
Input:
- Status: Percobaan
- TMT: 09-07-2026
- Gaji Pokok: 2050000

Expected:
- Masa Percobaan Mulai: 09-07-2026 ✅
- Masa Percobaan Selesai: 09-10-2026 ✅
- TST Kerja: 09-10-2026 ✅ (auto, readonly)
- Gaji Diterima: 1640000 (80%) ✅
```

### Test Case 3: Pegawai Aktif

```
Input:
- Status: Aktif
- TMT: 09-07-2026
- TST: 31-12-2026 (manual input)
- Gaji Pokok: 2050000

Expected:
- TST Kerja: 31-12-2026 ✅ (bisa input manual)
- Gaji Diterima: 2050000 (100%) ✅
- Tidak ada masa percobaan ✅
```

### Test Case 4: Print SK

```
Action: Print SK dengan banyak konten

Expected:
- Tanda tangan tidak terpotong ✅
- Page break sempurna ✅
- Layout rapi ✅
```

---

## ✅ Checklist Implementasi

- [x] Fix input gaji pokok (auto clean non-digit)
- [x] Fix TST untuk percobaan (auto set = masa percobaan selesai)
- [x] Fix TST readonly untuk percobaan
- [x] Fix TST editable untuk aktif
- [x] Fix tanda tangan terpotong (PKS Individu)
- [x] Fix tanda tangan terpotong (PKS Kolektif)
- [x] Fix tanda tangan terpotong (SPT Individu)
- [x] Fix tanda tangan terpotong (SPT Kolektif)
- [x] Update JavaScript kalkulasi gaji
- [x] Update JavaScript kalkulasi masa percobaan
- [x] Dokumentasi lengkap

---

## 🎉 Status: **COMPLETED**

Semua 3 masalah telah diperbaiki dan siap untuk testing!

**Next Step**:

1. Test input pegawai baru dengan status Percobaan
2. Cek apakah TST otomatis = masa percobaan selesai
3. Test print SK dan cek tanda tangan tidak terpotong
4. Test input gaji dengan format berbeda (dengan titik/koma)

---

## 📅 Changelog

**Date**: 12 Januari 2026  
**Issues Fixed**:

1. Gaji pokok terlalu besar (205 juta)
2. TST tidak sesuai masa percobaan
3. Tanda tangan terpotong saat print

**Developer**: [Your Name]
