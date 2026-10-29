# Implementasi SweetAlert2

Dokumen ini menjelaskan cara SweetAlert2 diintegrasikan ke dalam SI-Talenta sebagai pengganti dialog `confirm()` bawaan browser dan Bootstrap alert untuk flash message.

---

## Daftar Isi

1. [Kenapa SweetAlert2](#kenapa-sweetalert2)
2. [Instalasi](#instalasi)
3. [Arsitektur Implementasi](#arsitektur-implementasi)
4. [Konfirmasi Hapus](#konfirmasi-hapus)
5. [Flash Message](#flash-message)
6. [Cara Menambah di Halaman Baru](#cara-menambah-di-halaman-baru)
7. [Kustomisasi](#kustomisasi)

---

## Kenapa SweetAlert2

`confirm()` bawaan browser memiliki beberapa kelemahan:

- Tampilan berbeda di setiap browser, tidak bisa dikustomisasi
- Tidak bisa diblokir (beberapa browser modern menonaktifkan `confirm()` di dalam iframe)
- Tidak ada animasi atau branding yang konsisten dengan UI aplikasi

SweetAlert2 memberikan dialog yang konsisten, animasi halus, dan sepenuhnya bisa dikustomisasi.

---

## Instalasi

Tidak menggunakan npm. Library dimuat via CDN langsung di file layout utama.

**File:** `app/Views/dashboard/main.php`

```html
<!-- Letakkan di dalam <head>, sebelum tag penutup </head> -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
```

> Versi yang dipakai: **SweetAlert2 v11** (versi stabil terbaru saat implementasi).
> Karena dimuat di layout utama (`main.php`), SweetAlert2 otomatis tersedia di **semua halaman** yang menggunakan layout ini — tidak perlu import ulang.

---

## Arsitektur Implementasi

Seluruh logika SweetAlert2 dipusatkan di satu blok `<script>` di dalam `main.php`, menggunakan event delegation. Ini berarti:

- **Tidak perlu ubah tiap view satu per satu** untuk menambah konfirmasi
- Cukup pastikan form delete memiliki action URL yang cocok dengan selector
- Flash message dari controller PHP ditangkap otomatis via elemen tersembunyi

```
Controller PHP
    │
    │  redirect()->with('success', 'Pesan...')
    ▼
main.php (layout)
    │  <span id="swal-flash-success" data-message="...">
    │
    ▼
Script global di main.php
    ├── Intercept form delete → konfirmasi SweetAlert2
    └── Baca span flash → tampilkan toast/modal SweetAlert2
```

---

## Konfirmasi Hapus

### Cara Kerja

Script mencari semua form yang URL action-nya mengandung `/delete/`, `/user_delete/`, atau `/hapus`, lalu menempel event listener `submit` yang mencegat pengiriman form dan memunculkan dialog konfirmasi terlebih dahulu.

**Kode di `main.php`:**

```javascript
document.querySelectorAll(
  'form[action*="/delete/"], form[action*="/user_delete/"], form[action*="/hapus"]'
).forEach(function (form) {
  form.addEventListener('submit', function (e) {
    e.preventDefault(); // tahan pengiriman form

    const label = form.dataset.label || 'data ini';

    Swal.fire({
      title: 'Hapus Data?',
      html: 'Data <strong>' + label + '</strong> akan dihapus permanen dan tidak bisa dikembalikan.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#e74c3c',
      cancelButtonColor: '#6c757d',
      confirmButtonText: '<i class="fa fa-trash"></i> Ya, Hapus',
      cancelButtonText: 'Batal',
      reverseButtons: true,  // Batal di kanan, Hapus di kiri
      focusCancel: true,     // Default fokus di Batal (lebih aman)
    }).then(function (result) {
      if (result.isConfirmed) {
        form.submit(); // baru submit jika user klik Ya
      }
    });
  });
});
```

### Menampilkan Nama Item di Dialog

Tambahkan atribut `data-label` pada form delete di view. Nilainya diisi dari variabel PHP yang berisi nama item.

**Contoh di `unit_kerja.php`:**

```html
<form action="<?= site_url('unit_kerja/delete/' . $uk['id_unit_kerja_encrypted']) ?>"
      method="post"
      style="display:contents"
      data-label="<?= esc($uk['unit_kerja']) ?>">
  <?= csrf_field() ?>
  <button type="submit" class="btn btn-danger btn-sm rounded-pill px-2">
    <i class="fa fa-trash"></i>
  </button>
</form>
```

Jika `data-label` tidak ada, dialog akan menampilkan teks fallback `"data ini"`.

### Selector URL yang Dicegat

| Pattern URL | Berlaku untuk |
|---|---|
| `action*="/delete/"` | Semua hapus master data (unit kerja, pekerja, dll.) |
| `action*="/user_delete/"` | Hapus user sistem |
| `action*="/hapus"` | Hapus riwayat kerja |

Untuk menambah pattern baru, cukup tambahkan ke selector di `main.php`:

```javascript
// Tambah pattern baru di sini
document.querySelectorAll(
  'form[action*="/delete/"], form[action*="/user_delete/"], form[action*="/hapus"], form[action*="/remove/"]'
)
```

---

## Flash Message

### Cara Kerja

Controller CI4 mengirim flash message via `redirect()->with('success', '...')` atau `redirect()->with('error', '...')`. Layout `main.php` menangkap nilai ini dan meletakkannya di elemen `<span>` tersembunyi. Script SweetAlert2 membaca elemen tersebut saat halaman dimuat.

### Elemen Tersembunyi di `main.php`

```php
<body>
  <?php if (session()->getFlashdata('success')): ?>
    <span id="swal-flash-success"
          data-message="<?= esc(session()->getFlashdata('success')) ?>"
          style="display:none">
    </span>
  <?php endif; ?>

  <?php if (session()->getFlashdata('error')): ?>
    <span id="swal-flash-error"
          data-message="<?= esc(session()->getFlashdata('error')) ?>"
          style="display:none">
    </span>
  <?php endif; ?>
```

### Script Pembaca Flash di `main.php`

```javascript
// Flash sukses → toast pojok kanan atas, auto-tutup 2.5 detik
const flashSuccess = document.getElementById('swal-flash-success');
if (flashSuccess) {
  Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: flashSuccess.dataset.message,
    timer: 2500,
    timerProgressBar: true,
    showConfirmButton: false,
    toast: true,
    position: 'top-end',
  });
}

// Flash error → modal di tengah layar
const flashError = document.getElementById('swal-flash-error');
if (flashError) {
  Swal.fire({
    icon: 'error',
    title: 'Gagal!',
    text: flashError.dataset.message,
    confirmButtonColor: '#e74c3c',
    confirmButtonText: 'Tutup',
  });
}
```

### Penggunaan di Controller

Tidak ada yang perlu diubah di controller — cukup pakai `redirect()->with()` seperti biasa:

```php
// Sukses
return redirect()->to('/unit_kerja')->with('success', 'Unit kerja berhasil dihapus.');

// Error
return redirect()->back()->with('error', 'Data tidak ditemukan.');
```

---

## Cara Menambah di Halaman Baru

### Skenario 1: Halaman baru dengan tombol hapus

1. Buat form dengan `action` yang mengandung `/delete/` (sudah otomatis dicegat)
2. Tambahkan `data-label` berisi nama item
3. Hapus `onclick="return confirm(...)"` dari tombol — sudah tidak diperlukan

```html
<!-- ✅ Cara yang benar -->
<form action="<?= site_url('modul_baru/delete/' . $row['id_encrypted']) ?>"
      method="post"
      style="display:contents"
      data-label="<?= esc($row['nama']) ?>">
  <?= csrf_field() ?>
  <button type="submit" class="btn btn-danger btn-sm rounded-pill px-2">
    <i class="fa fa-trash"></i>
  </button>
</form>

<!-- ❌ Jangan lakukan ini lagi -->
<button onclick="return confirm('Yakin hapus?')">Hapus</button>
```

### Skenario 2: Konfirmasi custom (bukan hapus)

Gunakan SweetAlert2 langsung via JavaScript untuk aksi lain seperti persetujuan, perubahan status, dll.

```javascript
// Contoh: konfirmasi verifikasi penugasan
document.getElementById('btn-verifikasi').addEventListener('click', function(e) {
  e.preventDefault();
  const form = this.closest('form');

  Swal.fire({
    title: 'Verifikasi Penugasan?',
    text: 'Penugasan yang sudah diverifikasi tidak dapat dibatalkan.',
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#2ecc71',
    cancelButtonColor: '#6c757d',
    confirmButtonText: 'Ya, Verifikasi',
    cancelButtonText: 'Batal',
  }).then(function(result) {
    if (result.isConfirmed) form.submit();
  });
});
```

### Skenario 3: Tampilkan SweetAlert2 dari AJAX response

```javascript
$.ajax({
  url: '/some/endpoint',
  method: 'POST',
  data: { id: id },
  success: function(res) {
    if (res.success) {
      Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: res.message,
        timer: 2000,
        timerProgressBar: true,
        showConfirmButton: false,
        toast: true,
        position: 'top-end',
      });
    } else {
      Swal.fire({ icon: 'error', title: 'Gagal!', text: res.message });
    }
  }
});
```

---

## Kustomisasi

### Mengubah Warna Tombol Global

Edit di blok script `main.php`:

```javascript
confirmButtonColor: '#e74c3c',  // warna tombol konfirmasi (merah default)
cancelButtonColor: '#6c757d',   // warna tombol batal (abu-abu default)
```

### Mengubah Posisi Toast

```javascript
position: 'top-end',    // pojok kanan atas (default)
position: 'top-start',  // pojok kiri atas
position: 'bottom-end', // pojok kanan bawah
position: 'center',     // tengah layar
```

### Mengubah Durasi Auto-Close Toast

```javascript
timer: 2500, // dalam milidetik (2500 = 2.5 detik)
```

### Referensi Lengkap

Dokumentasi resmi SweetAlert2: [sweetalert2.github.io](https://sweetalert2.github.io)

---

## File yang Terlibat

| File | Peran |
|---|---|
| `app/Views/dashboard/main.php` | Load CDN, inject flash span, script global intercept + flash handler |
| `app/Views/*/view_tabel.php` | Tambah `data-label` pada form delete, hapus `onclick confirm` |

**Tanggal implementasi:** 29 Oktober 2026
