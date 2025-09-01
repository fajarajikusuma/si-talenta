<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Data Pekerja
$routes->get('/data_pekerja/aktif', 'DataPekerja::index');
$routes->get('/data_pekerja/new', 'DataPekerja::new');
$routes->get('/data_pekerja/out', 'DataPekerja::nonaktif');
$routes->get('/data_pekerja/pensiun', 'DataPekerja::pensiun');
$routes->get('/data_pekerja/add', 'DataPekerja::add');
$routes->post('/data_pekerja/store', 'DataPekerja::store');
$routes->get('/data_pekerja/edit/(:any)', 'DataPekerja::edit/$1');
$routes->post('/data_pekerja/update/(:any)', 'DataPekerja::update/$1');
$routes->get('/data_pekerja/delete/(:any)', 'DataPekerja::delete/$1');
$routes->get('/data_pekerja/detail/(:any)', 'DataPekerja::detail/$1');
$routes->get('/data_pekerja/verifikasi/(:any)', 'DataPekerja::verifikasi/$1');
$routes->post('/data_pekerja/simpan_verifikasi/(:any)', 'DataPekerja::simpan_verifikasi/$1');
$routes->get('data_pekerja/cetak_usulan/(:segment)', 'DataPekerja::cetak_usulan/$1');
$routes->post('/data_pekerja/import_excel', 'DataPekerja::import_excel_pekerja');
$routes->get('/data_pekerja/download_template', 'DataPekerja::download_template');
$routes->get('/data_pekerja/ajax_detail_pensiun', 'DataPekerja::ajaxDetailPensiun');

// Riwayat Kerja
$routes->get('/riwayat_kerja/riwayat/(:any)', 'RiwayatKerja::riwayat/$1');
$routes->get('/riwayat_kerja/add/(:any)', 'RiwayatKerja::add/$1');
$routes->post('/riwayat_kerja/store/(:any)', 'RiwayatKerja::store/$1');
$routes->get('/riwayat_kerja/download_template', 'RiwayatKerja::download_template');
$routes->post('/riwayat_kerja/import_excel', 'RiwayatKerja::import_excel');
$routes->post('riwayat_kerja/upload', 'RiwayatKerja::upload');
$routes->post('riwayat_kerja/hapus', 'RiwayatKerja::hapus');
$routes->post('riwayat_kerja/input_gaji_uraian', 'RiwayatKerja::input_gaji_uraian');
$routes->get('riwayat_kerja/detail/(:any)', 'RiwayatKerja::detail/$1');
$routes->post('riwayat_kerja/getGajiUraian', 'RiwayatKerja::getGajiUraian');


// Unit Kerja
$routes->get('/unit_kerja', 'UnitKerja::index');
$routes->get('/unit_kerja/add', 'UnitKerja::add');
$routes->post('/unit_kerja/store', 'UnitKerja::store');
$routes->get('/unit_kerja/edit/(:any)', 'UnitKerja::edit/$1');
$routes->post('/unit_kerja/update/(:any)', 'UnitKerja::update/$1');
$routes->get('/unit_kerja/delete/(:any)', 'UnitKerja::delete/$1');

// Daftar Kepala
$routes->get('/daftar_kepala', 'DaftarKepala::index');
$routes->get('/daftar_kepala/add', 'DaftarKepala::add');
$routes->post('/daftar_kepala/store', 'DaftarKepala::store');
$routes->get('/daftar_kepala/edit/(:any)', 'DaftarKepala::edit/$1');
$routes->post('/daftar_kepala/update/(:any)', 'DaftarKepala::update/$1');
$routes->get('/daftar_kepala/delete/(:any)', 'DaftarKepala::delete/$1');
$routes->post('/daftar_kepala/change_status', 'DaftarKepala::change_status');
$routes->get('daftar_kepala/detail/(:any)', 'DaftarKepala::detail/$1');

// List Pekerjaan
$routes->get('/list_pekerjaan', 'ListPekerjaan::index');
$routes->get('/list_pekerjaan/add', 'ListPekerjaan::add');
$routes->post('/list_pekerjaan/store', 'ListPekerjaan::store');
$routes->get('/list_pekerjaan/edit/(:any)', 'ListPekerjaan::edit/$1');
$routes->post('/list_pekerjaan/update/(:any)', 'ListPekerjaan::update/$1');
$routes->get('/list_pekerjaan/delete/(:any)', 'ListPekerjaan::delete/$1');
$routes->post('/list_pekerjaan/import_excel', 'ListPekerjaan::import_excel');
$routes->get('/list_pekerjaan/download_template', 'ListPekerjaan::download_template');

// Penugasan
$routes->get('/penugasan', 'Penugasan::index');
$routes->post('/penugasan/ajukan_semua', 'Penugasan::ajukanSemua');
$routes->get('/cetak_usulan_tugas_baru', 'Penugasan::daftarPenugasan');
$routes->get('/cetak_penugasan', 'Penugasan::cetakPenugasan');
$routes->post('/verifikasi_penugasan', 'Penugasan::verifikasiPenugasan');
$routes->post('/cetak_usulan_tugas_baru', 'Penugasan::daftarPenugasan');

// User Sistem
$routes->get('/user_sistem', 'Auth::list_users');
$routes->get('/add_user', 'Auth::add_user');
$routes->post('/store_user', 'Auth::register');
$routes->get('/user_edit/(:any)', 'Auth::edit_user/$1');
$routes->post('/user_update/(:any)', 'Auth::update_user/$1');
$routes->post('/user_delete/(:any)', 'Auth::delete_user/$1');
$routes->get('/user_detail/(:any)', 'Auth::detail_user/$1');

// Auth
$routes->get('/login', 'Auth::index');
$routes->post('/login_load', 'Auth::login');
$routes->get('/logout', 'Auth::logout');

// Laporan
$routes->get('/laporan', 'Laporan::index');
$routes->get('/cetak_spt', 'Laporan::cetak_spt');
$routes->get('/cetak_pks', 'Laporan::cetak_pks');

// Dasar Hukum
$routes->get('/dasar_hukum', 'DasarHukum::index');
$routes->get('/dasar_hukum/add', 'DasarHukum::add');
$routes->post('/dasar_hukum/store', 'DasarHukum::store');
$routes->post('/dasar_hukum/change_status', 'DasarHukum::change_status');
$routes->get('/dasar_hukum/edit/(:any)', 'DasarHukum::edit/$1');
$routes->post('/dasar_hukum/update/(:any)', 'DasarHukum::update/$1');
$routes->get('/dasar_hukum/delete/(:any)', 'DasarHukum::delete/$1');
