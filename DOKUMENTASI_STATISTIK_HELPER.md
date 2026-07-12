# Dokumentasi Statistik Helper

Helper untuk menampilkan statistik data persebaran pegawai di landing page dengan kategori **umur**, **jenis kelamin**, dan **pendidikan** per bidang.

## File Location

```
app/Helpers/statistik_helper.php
```

## Cara Menggunakan

### 1. Load Helper

Untuk menggunakan helper ini, Anda perlu meload-nya terlebih dahulu di controller atau di `BaseController.php`:

```php
helper('statistik');
```

Atau di `app/Controllers/BaseController.php` agar tersedia di semua controller:

```php
protected $helpers = ['statistik'];
```

### 2. Fungsi-Fungsi yang Tersedia

#### 2.1 `getStatistikGlobal()`

Mendapatkan statistik global pegawai (total, aktif, pensiun, tidak aktif).

**Return:** Array

```php
[
    'aktif' => 150,
    'pensiun' => 20,
    'tidak_aktif' => 5,
    'total' => 175
]
```

**Contoh Penggunaan:**

```php
$statistik = getStatistikGlobal();
echo "Total Pegawai: " . $statistik['total'];
echo "Pegawai Aktif: " . $statistik['aktif'];
```

---

#### 2.2 `getStatistikUmur()`

Mendapatkan statistik pegawai berdasarkan rentang umur.

**Return:** Array

```php
[
    ['rentang_umur' => '20-30 Tahun', 'jumlah' => 30],
    ['rentang_umur' => '31-40 Tahun', 'jumlah' => 50],
    ['rentang_umur' => '41-50 Tahun', 'jumlah' => 45],
    ['rentang_umur' => '51-58 Tahun', 'jumlah' => 20],
    ['rentang_umur' => '> 58 Tahun', 'jumlah' => 5]
]
```

**Contoh Penggunaan:**

```php
$statistikUmur = getStatistikUmur();
foreach($statistikUmur as $data) {
    echo $data['rentang_umur'] . ": " . $data['jumlah'] . " orang<br>";
}
```

---

#### 2.3 `getStatistikJenisKelamin()`

Mendapatkan statistik pegawai berdasarkan jenis kelamin.

**Return:** Array

```php
[
    ['jenis_kelamin' => 'Laki-laki', 'jumlah' => 100],
    ['jenis_kelamin' => 'Perempuan', 'jumlah' => 75]
]
```

**Contoh Penggunaan:**

```php
$statistikJK = getStatistikJenisKelamin();
foreach($statistikJK as $data) {
    echo $data['jenis_kelamin'] . ": " . $data['jumlah'] . " orang<br>";
}
```

---

#### 2.4 `getStatistikPendidikan()`

Mendapatkan statistik pegawai berdasarkan tingkat pendidikan.

**Return:** Array

```php
[
    ['tingkat_pendidikan' => 'SD', 'jumlah' => 10],
    ['tingkat_pendidikan' => 'SMP', 'jumlah' => 15],
    ['tingkat_pendidikan' => 'SMA', 'jumlah' => 40],
    ['tingkat_pendidikan' => 'SMK', 'jumlah' => 30],
    ['tingkat_pendidikan' => 'D3', 'jumlah' => 20],
    ['tingkat_pendidikan' => 'S1', 'jumlah' => 50],
    ['tingkat_pendidikan' => 'S2', 'jumlah' => 10],
    ['tingkat_pendidikan' => 'S3', 'jumlah' => 0]
]
```

**Contoh Penggunaan:**

```php
$statistikPendidikan = getStatistikPendidikan();
foreach($statistikPendidikan as $data) {
    echo $data['tingkat_pendidikan'] . ": " . $data['jumlah'] . " orang<br>";
}
```

---

#### 2.5 `getStatistikPerBidang()`

Mendapatkan statistik lengkap pegawai per bidang unit kerja (status, umur, jenis kelamin, dan pendidikan).

**Return:** Array

```php
[
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
        'jenis_kelamin_laki' => 15,
        'jenis_kelamin_perempuan' => 14,
        'pendidikan_sd' => 2,
        'pendidikan_smp' => 3,
        'pendidikan_sma' => 8,
        'pendidikan_smk' => 6,
        'pendidikan_d3' => 4,
        'pendidikan_s1' => 5,
        'pendidikan_s2' => 1,
        'pendidikan_s3' => 0
    ],
    // ... data bidang lainnya
]
```

**Contoh Penggunaan:**

```php
$statistikPerBidang = getStatistikPerBidang();
foreach($statistikPerBidang as $bidang) {
    echo "<h3>" . $bidang['bidang'] . "</h3>";
    echo "Total Pegawai: " . $bidang['total'] . "<br>";
    echo "Aktif: " . $bidang['aktif'] . "<br>";
    echo "Laki-laki: " . $bidang['jenis_kelamin_laki'] . "<br>";
    echo "Perempuan: " . $bidang['jenis_kelamin_perempuan'] . "<br>";
}
```

---

#### 2.6 `getStatistikBidangById($idUnitKerja)`

Mendapatkan statistik pegawai untuk bidang tertentu berdasarkan ID unit kerja.

**Parameter:**

- `$idUnitKerja` (int) - ID Unit Kerja/Bidang

**Return:** Array atau NULL (jika tidak ditemukan)

**Contoh Penggunaan:**

```php
$statistikBidang = getStatistikBidangById(1);
if($statistikBidang) {
    echo "Bidang: " . $statistikBidang['bidang'] . "<br>";
    echo "Total: " . $statistikBidang['total'] . "<br>";
}
```

---

#### 2.7 `getPersentaseStatistik($jumlah, $total, $desimal = 1)`

Menghitung persentase dari statistik.

**Parameter:**

- `$jumlah` (int) - Jumlah item
- `$total` (int) - Total keseluruhan
- `$desimal` (int, optional) - Jumlah angka desimal (default: 1)

**Return:** String

**Contoh Penggunaan:**

```php
$persenAktif = getPersentaseStatistik(150, 175); // "85.7"
echo "Pegawai Aktif: " . $persenAktif . "%";

$persenDetail = getPersentaseStatistik(150, 175, 2); // "85.71"
```

---

#### 2.8 `formatStatistikChart($data, $labelKey, $valueKey)`

Format data statistik untuk Chart.js.

**Parameter:**

- `$data` (array) - Data statistik
- `$labelKey` (string) - Key untuk label
- `$valueKey` (string) - Key untuk value

**Return:** Array dengan keys 'labels' dan 'values'

**Contoh Penggunaan:**

```php
$statistikUmur = getStatistikUmur();
$chartData = formatStatistikChart($statistikUmur, 'rentang_umur', 'jumlah');

// Output:
// [
//     'labels' => ['20-30 Tahun', '31-40 Tahun', ...],
//     'values' => [30, 50, ...]
// ]
```

**Implementasi di View dengan Chart.js:**

```javascript
const chartData = <?= json_encode(formatStatistikChart($statistikUmur, 'rentang_umur', 'jumlah')) ?>;

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: chartData.labels,
        datasets: [{
            label: 'Jumlah Pegawai',
            data: chartData.values
        }]
    }
});
```

---

#### 2.9 `getWarnaChart($type = 'blue')`

Mendapatkan array warna untuk chart berdasarkan tema.

**Parameter:**

- `$type` (string, optional) - Tipe warna: 'blue', 'green', 'teal', 'purple', 'orange' (default: 'blue')

**Return:** Array warna hex

**Contoh Penggunaan:**

```php
$warnaBlue = getWarnaChart('blue');
$warnaGreen = getWarnaChart('green');

// Output untuk blue:
// ['#3B82F6', '#60A5FA', '#93C5FD', '#BFDBFE', '#DBEAFE']
```

**Implementasi di Chart.js:**

```javascript
const colors = <?= json_encode(getWarnaChart('teal')) ?>;

new Chart(ctx, {
    type: 'doughnut',
    data: {
        datasets: [{
            backgroundColor: colors
        }]
    }
});
```

---

#### 2.10 `generateRingkasanStatistik($statistik)`

Generate ringkasan statistik dalam bentuk teks HTML.

**Parameter:**

- `$statistik` (array) - Data statistik dari `getStatistikGlobal()`

**Return:** String HTML

**Contoh Penggunaan:**

```php
$statistik = getStatistikGlobal();
$ringkasan = generateRingkasanStatistik($statistik);
echo $ringkasan;

// Output:
// "Dari total <strong>175 pegawai</strong>, terdapat <strong>150 pegawai aktif</strong> (85.7%),
// <strong>20 pensiun</strong> (11.4%), dan <strong>5 tidak aktif</strong>."
```

---

#### 2.11 `getBadgeStatusPegawai($status)`

Mendapatkan HTML badge untuk status pegawai.

**Parameter:**

- `$status` (string) - Status pegawai ('Terverifikasi', 'Pensiun', 'Tidak Aktif', 'Menunggu')

**Return:** String HTML

**Contoh Penggunaan:**

```php
echo getBadgeStatusPegawai('Terverifikasi');
// Output: <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">Aktif</span>

echo getBadgeStatusPegawai('Pensiun');
// Output: <span class="px-2 py-1 text-xs font-semibold rounded-full bg-teal-100 text-teal-700">Pensiun</span>
```

---

## Contoh Implementasi Lengkap di Controller

```php
<?php

namespace App\Controllers;

class LandingPage extends BaseController
{
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
            'statistikJenisKelamin' => getStatistikJenisKelamin(),
            'statistikPendidikan' => getStatistikPendidikan(),
            'statistikPerBidang' => getStatistikPerBidang(),
        ];

        return view('landing/index', $data);
    }

    public function detailBidang($id)
    {
        $statistik = getStatistikBidangById($id);

        if (!$statistik) {
            return redirect()->back()->with('error', 'Bidang tidak ditemukan');
        }

        $data = [
            'title' => 'Detail Bidang - ' . $statistik['bidang'],
            'statistik' => $statistik,
            'ringkasan' => generateRingkasanStatistik($statistik),
        ];

        return view('landing/detail_bidang', $data);
    }
}
```

## Contoh Implementasi di View

### Menampilkan Statistik Global

```php
<?php $statistik = getStatistikGlobal(); ?>

<div class="grid grid-cols-4 gap-4">
    <div class="card">
        <h4>Total Pegawai</h4>
        <p class="text-3xl font-bold"><?= $statistik['total'] ?></p>
    </div>
    <div class="card">
        <h4>Pegawai Aktif</h4>
        <p class="text-3xl font-bold text-green-600"><?= $statistik['aktif'] ?></p>
    </div>
    <div class="card">
        <h4>Pensiun</h4>
        <p class="text-3xl font-bold text-teal-600"><?= $statistik['pensiun'] ?></p>
    </div>
    <div class="card">
        <h4>Tidak Aktif</h4>
        <p class="text-3xl font-bold text-yellow-600"><?= $statistik['tidak_aktif'] ?></p>
    </div>
</div>
```

### Menampilkan Statistik Per Bidang dengan Jenis Kelamin

```php
<?php $statistikPerBidang = getStatistikPerBidang(); ?>

<?php foreach ($statistikPerBidang as $bidang): ?>
<div class="card">
    <h3><?= esc($bidang['bidang']) ?></h3>

    <div class="grid grid-cols-3 gap-3">
        <div>
            <p class="text-sm text-gray-500">Total</p>
            <p class="text-2xl font-bold"><?= $bidang['total'] ?></p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Laki-laki</p>
            <p class="text-2xl font-bold text-blue-600"><?= $bidang['jenis_kelamin_laki'] ?></p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Perempuan</p>
            <p class="text-2xl font-bold text-pink-600"><?= $bidang['jenis_kelamin_perempuan'] ?></p>
        </div>
    </div>

    <div class="mt-4">
        <h4 class="font-semibold mb-2">Rentang Umur</h4>
        <div class="grid grid-cols-4 gap-2">
            <div class="text-center p-2 bg-gray-50 rounded">
                <p class="text-xs text-gray-600">20-30</p>
                <p class="font-bold"><?= $bidang['umur_20_30'] ?></p>
            </div>
            <div class="text-center p-2 bg-gray-50 rounded">
                <p class="text-xs text-gray-600">31-40</p>
                <p class="font-bold"><?= $bidang['umur_31_40'] ?></p>
            </div>
            <div class="text-center p-2 bg-gray-50 rounded">
                <p class="text-xs text-gray-600">41-50</p>
                <p class="font-bold"><?= $bidang['umur_41_50'] ?></p>
            </div>
            <div class="text-center p-2 bg-gray-50 rounded">
                <p class="text-xs text-gray-600">51-58</p>
                <p class="font-bold"><?= $bidang['umur_51_58'] ?></p>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <h4 class="font-semibold mb-2">Tingkat Pendidikan</h4>
        <div class="grid grid-cols-5 gap-2">
            <div class="text-center p-2 bg-gray-50 rounded">
                <p class="text-xs text-gray-600">SD</p>
                <p class="font-bold"><?= $bidang['pendidikan_sd'] ?></p>
            </div>
            <div class="text-center p-2 bg-gray-50 rounded">
                <p class="text-xs text-gray-600">SMP</p>
                <p class="font-bold"><?= $bidang['pendidikan_smp'] ?></p>
            </div>
            <div class="text-center p-2 bg-gray-50 rounded">
                <p class="text-xs text-gray-600">SMA/K</p>
                <p class="font-bold"><?= (int)$bidang['pendidikan_sma'] + (int)$bidang['pendidikan_smk'] ?></p>
            </div>
            <div class="text-center p-2 bg-gray-50 rounded">
                <p class="text-xs text-gray-600">D3</p>
                <p class="font-bold"><?= $bidang['pendidikan_d3'] ?></p>
            </div>
            <div class="text-center p-2 bg-gray-50 rounded">
                <p class="text-xs text-gray-600">S1+</p>
                <p class="font-bold"><?= (int)$bidang['pendidikan_s1'] + (int)$bidang['pendidikan_s2'] + (int)$bidang['pendidikan_s3'] ?></p>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
```

### Membuat Chart dengan Chart.js

```php
<canvas id="chartJenisKelamin"></canvas>

<script>
    const dataJK = <?= json_encode(formatStatistikChart(getStatistikJenisKelamin(), 'jenis_kelamin', 'jumlah')) ?>;
    const warnaChart = <?= json_encode(getWarnaChart('blue')) ?>;

    new Chart(document.getElementById('chartJenisKelamin'), {
        type: 'pie',
        data: {
            labels: dataJK.labels,
            datasets: [{
                data: dataJK.values,
                backgroundColor: warnaChart
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                },
                title: {
                    display: true,
                    text: 'Distribusi Jenis Kelamin Pegawai'
                }
            }
        }
    });
</script>
```

## Tips Penggunaan

1. **Load Helper Sekali Saja**: Load helper di `BaseController.php` agar tersedia di semua controller
2. **Cache Data**: Untuk landing page yang diakses publik, pertimbangkan untuk cache hasil query
3. **Performa**: Query sudah dioptimasi dengan DISTINCT dan GROUP BY
4. **Customisasi Warna**: Gunakan `getWarnaChart()` untuk konsistensi warna di semua chart
5. **Format Data**: Gunakan `formatStatistikChart()` untuk mempermudah integrasi dengan Chart.js

## Catatan

- Semua fungsi sudah memperhitungkan `deleted_at` untuk soft delete
- Status pegawai yang dihitung: 'Terverifikasi', 'Pensiun', 'Tidak Aktif'
- Umur pensiun diasumsikan 58 tahun
- Query menggunakan riwayat pekerjaan terakhir (latest) untuk menghindari duplikasi data

---

**Created by:** SI-Talenta Development Team  
**Last Updated:** <?= date('d F Y') ?>
