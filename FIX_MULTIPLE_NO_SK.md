# Fix: Multiple Nomor SK dalam Satu Tahun

## 🐛 Masalah

Ketika ada **multiple** `tb_no_sk` dengan tahun yang sama (contoh: id 7 dan id 9 dengan tanggal penetapan berbeda), sistem hanya mengambil **satu record** pertama menggunakan `->first()`.

Akibatnya:

- Pegawai dengan SK di `id_no_sk` yang bukan yang pertama (misal id 9) tidak akan ditemukan
- Query `$skData` menghasilkan `null`
- SK tidak bisa dicetak

### Contoh Kasus:

```
tb_no_sk:
- id: 7, tahun: 2026, tanggal_penetapan: 2026-01-01
- id: 9, tahun: 2026, tanggal_penetapan: 2026-01-15 ← SK baru
```

**Kode Lama**:

```php
$noSk = model('App\Models\NoSkModel')
    ->where('tahun', date('Y'))
    ->first(); // ← Hanya ambil id 7

$skData = $this->skModel
    ->where('tb_sk.id_no_sk', $noSk['id_no_sk']) // ← Filter hanya id 7
    ->where('tb_sk.id_pekerja', $id_pekerja)
    ->first(); // ← Pegawai dengan SK id 9 tidak ketemu!
```

---

## ✅ Solusi

Ubah logika agar **tidak membatasi** berdasarkan `id_no_sk` spesifik. Query langsung berdasarkan:

1. `id_pekerja`
2. `tahun` (dari join ke `tb_no_sk`)
3. Ambil yang **tanggal penetapan terbaru** jika ada multiple

**Kode Baru**:

```php
// Tidak lagi ambil $noSk dengan ->first()
// Langsung query SK berdasarkan pekerja dan tahun

$skData = $this->skModel
    ->select('tb_sk.*, tb_no_sk.id_no_sk, tb_no_sk.tahun')
    ->join('tb_no_sk', 'tb_no_sk.id_no_sk = tb_sk.id_no_sk', 'inner')
    ->where('tb_sk.id_pekerja', $id_pekerja)
    ->where('tb_no_sk.tahun', date('Y')) // ← Filter tahun saja
    ->orderBy('tb_sk.tanggal_penetapan', 'DESC') // ← Ambil yang terbaru
    ->first(); // ← Akan dapat SK dengan id_no_sk apapun (7, 9, dll)
```

---

## 📝 File yang Diubah

### 1. `app/Controllers/Laporan.php`

#### Method: `cetak_pks_individu()`

**Before**:

```php
$noSk = model('App\Models\NoSkModel')
    ->where('tahun', date('Y'))
    ->first();

if (!$noSk) {
    return redirect()->back()->with('error', 'Nomor SK tahun ini belum dibuat.');
}

$cekSK = $this->skModel
    ->where('id_no_sk', $noSk['id_no_sk'])
    ->countAllResults();

$skData = $this->skModel
    ->select('tb_sk.*, tb_no_sk.id_no_sk')
    ->join('tb_no_sk', 'tb_no_sk.id_no_sk = tb_sk.id_no_sk', 'inner')
    ->where('tb_sk.id_pekerja', $id_pekerja)
    ->where('tb_sk.id_no_sk', $noSk['id_no_sk']) // ← MASALAH
    ->where('tb_no_sk.tahun', date('Y'))
    ->first();
```

**After**:

```php
// Hilangkan $noSk dan $cekSK
// Langsung query berdasarkan id_pekerja dan tahun

$skData = $this->skModel
    ->select('tb_sk.*, tb_no_sk.id_no_sk, tb_no_sk.tahun')
    ->join('tb_no_sk', 'tb_no_sk.id_no_sk = tb_sk.id_no_sk', 'inner')
    ->where('tb_sk.id_pekerja', $id_pekerja)
    ->where('tb_no_sk.tahun', date('Y'))
    ->orderBy('tb_sk.tanggal_penetapan', 'DESC') // Ambil yang terbaru
    ->first();
```

#### Method: `cetak_pks()`

**Before**:

```php
$noSk = model('App\Models\NoSkModel')
    ->where('tahun', date('Y'))
    ->first();

if (!$noSk) {
    return redirect()->back()->with('error', 'Nomor SK tahun ini belum dibuat.');
}

$cekSK = $this->skModel
    ->where('id_no_sk', $noSk['id_no_sk'])
    ->countAllResults();

// Di loop:
$skData = $this->skModel
    ->where('tb_sk.id_no_sk', $noSk['id_no_sk']) // ← MASALAH
    ->where('tb_sk.id_pekerja', $pekerja['id_pekerja'])
    ->first();
```

**After**:

```php
// Cek apakah ada SK untuk tahun ini (tidak perlu id_no_sk spesifik)
$cekSKTahunIni = $this->skModel
    ->select('tb_sk.*')
    ->join('tb_no_sk', 'tb_no_sk.id_no_sk = tb_sk.id_no_sk', 'inner')
    ->where('tb_no_sk.tahun', date('Y'))
    ->countAllResults();

if ($cekSKTahunIni === 0) {
    return redirect()->back()->with('error', 'Nomor SK untuk tahun ini belum digenerate.');
}

// Di loop:
$skData = $this->skModel
    ->select('tb_sk.*, tb_no_sk.id_no_sk, tb_no_sk.tahun')
    ->join('tb_no_sk', 'tb_no_sk.id_no_sk = tb_sk.id_no_sk', 'inner')
    ->where('tb_sk.id_pekerja', $pekerja['id_pekerja'])
    ->where('tb_no_sk.tahun', date('Y'))
    ->orderBy('tb_sk.tanggal_penetapan', 'DESC')
    ->first();
```

---

## 🧪 Testing

### Test Case 1: Single id_no_sk

```
Setup:
- tb_no_sk: id 7, tahun 2026, tanggal_penetapan: 2026-01-01
- tb_sk: Pegawai A dengan id_no_sk 7

Expected: ✅ SK Pegawai A berhasil dicetak
```

### Test Case 2: Multiple id_no_sk (Masalah Lama)

```
Setup:
- tb_no_sk: id 7, tahun 2026, tanggal_penetapan: 2026-01-01
- tb_no_sk: id 9, tahun 2026, tanggal_penetapan: 2026-01-15
- tb_sk: Pegawai A dengan id_no_sk 7
- tb_sk: Pegawai B dengan id_no_sk 9

Kode Lama:
- Pegawai A: ✅ Berhasil
- Pegawai B: ❌ Gagal (null)

Kode Baru:
- Pegawai A: ✅ Berhasil
- Pegawai B: ✅ Berhasil
```

### Test Case 3: Multiple SK untuk Satu Pegawai

```
Setup:
- tb_no_sk: id 7, tahun 2026, tanggal_penetapan: 2026-01-01
- tb_no_sk: id 9, tahun 2026, tanggal_penetapan: 2026-01-15
- tb_sk: Pegawai A dengan id_no_sk 7, tanggal_penetapan: 2026-01-01
- tb_sk: Pegawai A dengan id_no_sk 9, tanggal_penetapan: 2026-01-15

Expected: ✅ Ambil SK yang tanggal penetapan terbaru (2026-01-15)
```

---

## 🎯 Keuntungan Fix Ini

1. **Support Multiple Nomor SK**: Sistem sekarang mendukung multiple `id_no_sk` dalam satu tahun dengan tanggal penetapan berbeda
2. **Fleksibel**: Tidak tergantung urutan insert atau id terkecil
3. **Ambil Yang Terbaru**: Otomatis ambil SK dengan tanggal penetapan terbaru
4. **Backward Compatible**: Tetap berfungsi untuk single `id_no_sk`

---

## ⚠️ Catatan

### Use Case Multiple id_no_sk

Multiple `id_no_sk` dalam satu tahun bisa terjadi karena:

1. **Revisi SK**: Ada perbaikan SK dengan tanggal penetapan baru
2. **Batch Generate**: Generate SK di beberapa waktu berbeda dalam satu tahun
3. **Unit Kerja Berbeda**: Setiap unit kerja punya nomor SK sendiri

### Filter Tambahan (Opsional)

Jika ingin filter berdasarkan kriteria tambahan:

```php
$skData = $this->skModel
    ->where('tb_sk.id_pekerja', $id_pekerja)
    ->where('tb_no_sk.tahun', date('Y'))
    ->where('tb_no_sk.id_unit_kerja', $id_unit_kerja) // ← Filter per unit
    ->orderBy('tb_sk.tanggal_penetapan', 'DESC')
    ->first();
```

---

## 📅 Changelog

**Date**: 12 Januari 2026
**Issue**: Query SK menghasilkan null untuk pegawai dengan `id_no_sk` selain yang pertama
**Fix**: Ubah query agar tidak membatasi berdasarkan `id_no_sk` spesifik
**Impact**: ✅ Semua pegawai dengan SK di tahun berjalan bisa dicetak, terlepas dari `id_no_sk`

---

## ✅ Status: **FIXED**

Fix sudah diimplementasikan dan siap untuk testing.
