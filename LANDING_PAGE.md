# Landing Page SI-Talenta

## Deskripsi

Landing page profesional dan mewah untuk Sistem Informasi Talenta Dinas Lingkungan Hidup. Halaman ini menampilkan statistik lengkap pekerja sebelum pengguna masuk ke sistem.

## Fitur

### 1. Statistik Umum

- **Total Pekerja Aktif**: Menampilkan jumlah pekerja yang terverifikasi dan belum pensiun
- **Total Pekerja Pensiun**: Menampilkan jumlah pekerja yang sudah pensiun
- **Total Pekerja Tidak Aktif**: Menampilkan jumlah pekerja yang tidak aktif
- **Total Keseluruhan**: Akumulasi dari semua pekerja

### 2. Diagram Statistik

#### Diagram Umur

Menampilkan distribusi pekerja berdasarkan rentang umur:

- 20-30 Tahun
- 31-40 Tahun
- 41-50 Tahun
- 51-58 Tahun
- > 58 Tahun

Menggunakan **Doughnut Chart** untuk visualisasi yang menarik.

#### Diagram Pendidikan

Menampilkan distribusi pekerja berdasarkan tingkat pendidikan:

- SD
- SMP
- SMA
- SMK
- D3
- S1
- S2
- S3

Menggunakan **Bar Chart** untuk visualisasi yang jelas.

### 3. Statistik Per Bidang/Unit Kerja

Setiap bidang menampilkan:

- Jumlah pekerja aktif, pensiun, dan tidak aktif
- Detail statistik umur per bidang (dapat di-expand)
- Detail statistik pendidikan per bidang (dapat di-expand)

## Fitur Desain

### Visual

- **Animated Background**: Animasi floating shapes untuk kesan dinamis
- **Gradient Colors**: Penggunaan gradient modern untuk elemen-elemen penting
- **Glass Morphism**: Efek blur dan transparansi pada navbar
- **Hover Effects**: Animasi smooth pada card dan tombol
- **Responsive Design**: Tampilan optimal di semua device (mobile, tablet, desktop)

### Teknologi

- **Bootstrap 5.3**: Framework CSS responsif
- **Chart.js 4.4**: Library untuk diagram interaktif
- **AOS (Animate On Scroll)**: Library untuk animasi scroll
- **Font Awesome 6.4**: Icon library
- **Google Fonts (Poppins)**: Typography profesional

## Struktur File

```
app/
├── Controllers/
│   └── LandingPage.php      # Controller untuk landing page
├── Views/
│   └── landing/
│       └── index.php         # View landing page
└── Config/
    ├── Routes.php            # Routing configuration
    └── Filters.php           # Filter configuration
```

## Routing

```php
// Landing Page (Public - tidak perlu login)
$routes->get('/', 'LandingPage::index');

// Dashboard (Setelah Login)
$routes->get('/dashboard', 'Home::index');

// Login Page
$routes->get('/login', 'Auth::index');
```

## Akses

- **Landing Page**: Dapat diakses tanpa login di URL root (`/`)
- **Login**: Tombol di pojok kanan atas navbar
- **Dashboard**: Redirect otomatis setelah login ke `/dashboard`

## Method Controller

### `LandingPage::index()`

Method utama yang menampilkan landing page dengan semua data statistik.

### `LandingPage::getStatistik()`

Mengambil statistik umum:

- Total pekerja aktif
- Total pekerja pensiun
- Total pekerja tidak aktif
- Total keseluruhan

### `LandingPage::getStatistikUmur()`

Mengambil distribusi pekerja berdasarkan rentang umur dengan query SQL menggunakan `TIMESTAMPDIFF`.

### `LandingPage::getStatistikPendidikan()`

Mengambil distribusi pekerja berdasarkan tingkat pendidikan dengan ordering yang sesuai.

### `LandingPage::getStatistikPerBidang()`

Mengambil statistik lengkap per bidang/unit kerja termasuk:

- Status pekerja (aktif, pensiun, tidak aktif)
- Distribusi umur per bidang
- Distribusi pendidikan per bidang

## Database Query

Semua query menggunakan Query Builder CodeIgniter 4 dan optimized untuk performa:

- Menggunakan JOIN untuk relasi tabel
- Menggunakan subquery untuk mendapatkan riwayat terakhir
- Menggunakan CASE statement untuk grouping data
- Menggunakan aggregate functions (COUNT, MAX, etc.)

## Customization

### Warna

Warna dapat diubah melalui CSS variables di bagian `:root`:

```css
:root {
  --primary-color: #2c3e50;
  --secondary-color: #3498db;
  --accent-color: #e74c3c;
  --success-color: #27ae60;
  --warning-color: #f39c12;
}
```

### Chart

Konfigurasi chart dapat diubah di bagian JavaScript:

- Type: doughnut, bar, line, etc.
- Colors: backgroundColor array
- Options: responsive, legend, tooltip, etc.

## Browser Support

- Chrome (Latest)
- Firefox (Latest)
- Safari (Latest)
- Edge (Latest)
- Opera (Latest)

## Performance

- Lazy loading untuk images
- Minified CSS/JS dari CDN
- Optimized database queries
- Caching-ready structure

## Maintenance

### Update Data

Data diupdate secara real-time dari database. Tidak ada cache statis.

### Add New Statistics

Tambahkan method baru di `LandingPage` controller dan panggil di `index()` method.

### Modify Layout

Edit file `/app/Views/landing/index.php` untuk mengubah tampilan.

## Security

- CSRF Protection (via CodeIgniter)
- XSS Prevention (via CodeIgniter escaping)
- SQL Injection Prevention (via Query Builder)
- Public access hanya untuk landing page
- Authentication required untuk dashboard

## Notes

- Landing page tidak memerlukan autentikasi
- Semua route lain tetap memerlukan login (kecuali login page)
- Filter `LoginFilter` sudah dikonfigurasi untuk mengecualikan `/` dan `/login`
- Session handling untuk redirect yang proper setelah login
