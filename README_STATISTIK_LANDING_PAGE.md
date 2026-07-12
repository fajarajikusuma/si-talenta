# Implementasi Helper Statistik pada Landing Page

## 📋 Overview

Implementasi helper statistik untuk menampilkan data persebaran pegawai di landing page dengan tampilan profesional dan mewah. Data ditampilkan dalam kategori:

- ✅ **Umur** (rentang 20-30, 31-40, 41-50, 51-58 tahun)
- ✅ **Jenis Kelamin** (Laki-laki & Perempuan)
- ✅ **Pendidikan** (SD, SMP, SMA/SMK, D3, S1, S2, S3)
- ✅ **Per Bidang Unit Kerja** (semua statistik di atas per bidang)

## 🎨 Fitur Tampilan

### 1. **Ringkasan Data Interaktif**

- Card statistik dengan gradient background yang elegan
- Ringkasan teks otomatis dengan persentase menggunakan `generateRingkasanStatistik()`
- Icon dan border accent yang menarik

### 2. **Visualisasi Chart Profesional**

- **Chart Umur**: Doughnut chart dengan 5 rentang umur
- **Chart Jenis Kelamin**: Pie chart dengan warna blue (laki-laki) dan pink (perempuan)
- **Chart Pendidikan**: Bar chart horizontal untuk tingkat pendidikan

### 3. **Statistik Per Bidang**

- Accordion expandable untuk setiap bidang
- Kartu jenis kelamin dengan gradient dan icon
- Statistik umur dan pendidikan dalam grid responsive
- Hover effects untuk interaksi yang smooth

## 📁 File yang Dimodifikasi

### 1. Helper Statistik

**File:** `app/Helpers/statistik_helper.php`

Fungsi yang tersedia:

- `getStatistikGlobal()` - Statistik keseluruhan
- `getStatistikUmur()` - Data rentang umur
- `getStatistikJenisKelamin()` - Data jenis kelamin ✨ BARU
- `getStatistikPendidikan()` - Data pendidikan
- `getStatistikPerBidang()` - Data lengkap per bidang (termasuk jenis kelamin)
- `getStatistikBidangById($id)` - Data bidang spesifik
- `getPersentaseStatistik($jumlah, $total, $desimal)` - Hitung persentase
- `formatStatistikChart($data, $labelKey, $valueKey)` - Format untuk Chart.js
- `getWarnaChart($type)` - Array warna untuk chart
- `generateRingkasanStatistik($statistik)` - Generate ringkasan HTML
- `getBadgeStatusPegawai($status)` - Badge HTML untuk status

### 2. Controller Landing Page

**File:** `app/Controllers/LandingPage.php`

```php
public function __construct()
{
    helper('statistik'); // Load helper
}

public function index()
{
    $data = [
        'title' => 'SI-Talenta - Sistem Informasi Talenta',
        'statistik' => getStatistikGlobal(),
        'statistikUmur' => getStatistikUmur(),
        'statistikJenisKelamin' => getStatistikJenisKelamin(), // ✨ BARU
        'statistikPendidikan' => getStatistikPendidikan(),
        'statistikPerBidang' => getStatistikPerBidang(),
    ];

    return view('landing/index', $data);
}
```

### 3. View Landing Page

**File:** `app/Views/landing/index.php`

**Perubahan:**

#### a. Ringkasan Statistik (BARU)

```html
<div
  class="bg-gradient-to-r from-blue-50 to-teal-50 rounded-xl p-6 mb-10 border border-blue-100"
>
  <div class="flex items-center mb-3">
    <div
      class="w-10 h-10 rounded-lg bg-white shadow-sm flex items-center justify-center mr-3"
    >
      <i class="fas fa-info-circle text-blue-600"></i>
    </div>
    <h3 class="text-lg font-bold text-slate-800">Ringkasan Data</h3>
  </div>
  <p class="text-slate-600 leading-relaxed">
    <?= generateRingkasanStatistik($statistik) ?>
  </p>
</div>
```

#### b. Grid Chart 3 Kolom (dari 2 kolom)

```html
<div class="grid lg:grid-cols-3 gap-6">
  <!-- Chart Umur -->
  <div
    class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 hover:shadow-md transition-shadow"
  >
    <h3
      class="text-base font-bold text-slate-800 mb-6 flex items-center pb-3 border-b border-slate-100"
    >
      <i class="fas fa-calendar-alt text-blue-500 mr-2"></i>
      Distribusi Rentang Umur
    </h3>
    <canvas id="chartUmur"></canvas>
  </div>

  <!-- Chart Jenis Kelamin (✨ BARU) -->
  <div
    class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 hover:shadow-md transition-shadow"
  >
    <h3
      class="text-base font-bold text-slate-800 mb-6 flex items-center pb-3 border-b border-slate-100"
    >
      <i class="fas fa-venus-mars text-purple-500 mr-2"></i>
      Distribusi Jenis Kelamin
    </h3>
    <canvas id="chartJenisKelamin"></canvas>
  </div>

  <!-- Chart Pendidikan -->
  <div
    class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 hover:shadow-md transition-shadow"
  >
    <h3
      class="text-base font-bold text-slate-800 mb-6 flex items-center pb-3 border-b border-slate-100"
    >
      <i class="fas fa-graduation-cap text-teal-500 mr-2"></i>
      Distribusi Pendidikan
    </h3>
    <canvas id="chartPendidikan"></canvas>
  </div>
</div>
```

#### c. Statistik Jenis Kelamin Per Bidang (BARU)

```html
<div>
  <h5 class="text-sm font-semibold mb-3 text-slate-700 flex items-center">
    <i class="fas fa-venus-mars text-purple-500 mr-2"></i>
    Jenis Kelamin
  </h5>
  <div class="grid grid-cols-2 gap-3">
    <div
      class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg border border-blue-200 p-4 text-center"
    >
      <div class="flex items-center justify-center mb-2">
        <i class="fas fa-mars text-blue-600 text-xl mr-2"></i>
        <div class="text-xs text-blue-700 font-medium">Laki-laki</div>
      </div>
      <div class="text-2xl font-bold text-blue-700">
        <?= $bidang['jenis_kelamin_laki'] ?>
      </div>
      <div class="text-xs text-blue-600 mt-1">
        <?= getPersentaseStatistik($bidang['jenis_kelamin_laki'],
        $bidang['total']) ?>%
      </div>
    </div>
    <div
      class="bg-gradient-to-br from-pink-50 to-pink-100 rounded-lg border border-pink-200 p-4 text-center"
    >
      <div class="flex items-center justify-center mb-2">
        <i class="fas fa-venus text-pink-600 text-xl mr-2"></i>
        <div class="text-xs text-pink-700 font-medium">Perempuan</div>
      </div>
      <div class="text-2xl font-bold text-pink-700">
        <?= $bidang['jenis_kelamin_perempuan'] ?>
      </div>
      <div class="text-xs text-pink-600 mt-1">
        <?= getPersentaseStatistik($bidang['jenis_kelamin_perempuan'],
        $bidang['total']) ?>%
      </div>
    </div>
  </div>
</div>
```

#### d. Chart.js dengan Helper Integration

```javascript
// Data dari helper dengan formatStatistikChart()
const dataUmur = <?= json_encode(formatStatistikChart($statistikUmur, 'rentang_umur', 'jumlah')) ?>;
const dataJenisKelamin = <?= json_encode(formatStatistikChart($statistikJenisKelamin, 'jenis_kelamin', 'jumlah')) ?>;
const dataPendidikan = <?= json_encode(formatStatistikChart($statistikPendidikan, 'tingkat_pendidikan', 'jumlah')) ?>;

// Warna dari helper
const warnaBlue = <?= json_encode(getWarnaChart('blue')) ?>;
const warnaTeal = <?= json_encode(getWarnaChart('teal')) ?>;

// Chart Jenis Kelamin (Pie)
new Chart(document.getElementById('chartJenisKelamin'), {
    type: 'pie',
    data: {
        labels: dataJenisKelamin.labels,
        datasets: [{
            data: dataJenisKelamin.values,
            backgroundColor: [
                '#3b82f6', // blue-500 untuk Laki-laki
                '#ec4899'  // pink-500 untuk Perempuan
            ],
            borderWidth: 3,
            borderColor: '#ffffff',
            hoverOffset: 8,
            hoverBorderWidth: 4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 15,
                    usePointStyle: true,
                    pointStyle: 'circle',
                    font: { size: 12, weight: '500' }
                }
            },
            tooltip: {
                backgroundColor: '#1e293b',
                padding: 12,
                cornerRadius: 8,
                callbacks: {
                    label: function(context) {
                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                        const percentage = ((context.parsed / total) * 100).toFixed(1);
                        return ' ' + context.parsed + ' Orang (' + percentage + '%)';
                    }
                }
            }
        }
    }
});
```

## 🎨 Design System

### Warna Tema

- **Primary Blue**: `#3b82f6` (blue-500) - Laki-laki, Aktif
- **Primary Pink**: `#ec4899` (pink-500) - Perempuan
- **Primary Teal**: `#14b8a6` (teal-500) - Pendidikan
- **Accent Sky**: `#0ea5e9` (sky-500)
- **Accent Amber**: `#f59e0b` (amber-500)
- **Background**: `#f8fafc` (slate-50)
- **Border**: `#e2e8f0` (slate-200)

### Typography

- **Font Family**: Inter (Google Fonts)
- **Heading**: 700-900 weight
- **Body**: 400-600 weight
- **Small Text**: 300-500 weight

### Spacing

- **Card Padding**: 1.5rem (p-6)
- **Section Padding**: 5rem vertical (py-20)
- **Gap**: 1.5rem (gap-6)

### Effects

- **Box Shadow Soft**: `0 4px 20px -2px rgba(0, 0, 0, 0.05)`
- **Box Shadow Hover**: `0 10px 40px -5px rgba(0, 0, 0, 0.08)`
- **Transition**: `all 0.3s ease`
- **Border Radius**: 0.75rem (rounded-xl)

## 📊 Data Structure

### Statistik Per Bidang

```php
[
    'bidang' => 'Sekretariat',
    'id_unit_kerja' => 1,
    'aktif' => 25,
    'pensiun' => 3,
    'tidak_aktif' => 1,
    'total' => 29,
    'umur_20_30' => 5,
    'umur_31_40' => 10,
    'umur_41_50' => 9,
    'umur_51_58' => 5,
    'umur_lebih_58' => 0,
    'jenis_kelamin_laki' => 15,        // ✨ BARU
    'jenis_kelamin_perempuan' => 14,    // ✨ BARU
    'pendidikan_sd' => 2,
    'pendidikan_smp' => 3,
    'pendidikan_sma' => 8,
    'pendidikan_smk' => 6,
    'pendidikan_d3' => 4,
    'pendidikan_s1' => 5,
    'pendidikan_s2' => 1,
    'pendidikan_s3' => 0
]
```

## 🚀 Cara Menggunakan

### 1. Load Helper di Controller

```php
helper('statistik');
```

### 2. Panggil Fungsi di Controller

```php
$data = [
    'statistik' => getStatistikGlobal(),
    'statistikUmur' => getStatistikUmur(),
    'statistikJenisKelamin' => getStatistikJenisKelamin(),
    'statistikPendidikan' => getStatistikPendidikan(),
    'statistikPerBidang' => getStatistikPerBidang(),
];
```

### 3. Tampilkan di View

```php
<!-- Ringkasan -->
<?= generateRingkasanStatistik($statistik) ?>

<!-- Chart dengan Helper -->
<?php $chartData = formatStatistikChart($statistikUmur, 'rentang_umur', 'jumlah'); ?>
<script>
const data = <?= json_encode($chartData) ?>;
const colors = <?= json_encode(getWarnaChart('blue')) ?>;
</script>

<!-- Persentase -->
<?= getPersentaseStatistik($bidang['jenis_kelamin_laki'], $bidang['total']) ?>%
```

## 📱 Responsive Design

- **Mobile**: 1 kolom untuk chart dan card
- **Tablet**: 2 kolom untuk chart, grid layout untuk data
- **Desktop**: 3 kolom untuk chart, optimized layout

## ⚡ Optimisasi

1. **Query Database**: Menggunakan subquery untuk riwayat terakhir
2. **Chart.js**: Lazy load dan optimized rendering
3. **Helper Functions**: Reusable dan DRY (Don't Repeat Yourself)
4. **CSS**: Tailwind utility classes untuk performa maksimal

## 📚 Dokumentasi Lengkap

Lihat file berikut untuk dokumentasi detail:

- `DOKUMENTASI_STATISTIK_HELPER.md` - Dokumentasi lengkap semua fungsi helper
- `app/Helpers/statistik_helper.php` - Source code helper dengan comment

## 🎯 Hasil Akhir

Landing page sekarang menampilkan:
✅ Statistik global yang informatif
✅ 3 chart visualisasi profesional (Umur, Jenis Kelamin, Pendidikan)
✅ Ringkasan otomatis dengan persentase
✅ Statistik detail per bidang dengan accordion
✅ Data jenis kelamin dengan gradient card yang menarik
✅ Hover effects dan transisi yang smooth
✅ Responsive di semua device
✅ Konsisten dengan design system

## 🌟 Tips

1. Data di-cache untuk performa optimal di production
2. Gunakan `getWarnaChart()` untuk konsistensi warna
3. Semua fungsi helper sudah handle null/empty data
4. Chart.js sudah dioptimasi dengan Inter font
5. Persentase otomatis dihitung dengan `getPersentaseStatistik()`

---

**Developer:** SI-Talenta Development Team  
**Last Updated:** <?= date('d F Y H:i') ?>  
**Version:** 1.0.0
