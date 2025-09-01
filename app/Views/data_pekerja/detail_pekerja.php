<?= $this->extend('dashboard/main') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-lg-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Detail Data <?= $subtitle ?></h4>
                <p class="card-description">Informasi lengkap data pekerja</p>

                <div class="overflow-auto">
                    <table class="table table-bordered" id="tableDetail">
                        <tbody>
                            <tr>
                                <th>NIK</th>
                                <td><?= esc($pekerja['nik']) ?></td>
                            </tr>
                            <tr>
                                <th>Nama Lengkap</th>
                                <td><?= esc($pekerja['nama']) ?></td>
                            </tr>
                            <tr>
                                <th>Tempat, Tanggal Lahir</th>
                                <td><?= esc($pekerja['tempat_lahir']) ?>, <?= date('d-m-Y', strtotime(esc($pekerja['tanggal_lahir']))) ?></td>
                            </tr>
                            <tr>
                                <th>Jenis Kelamin</th>
                                <td><?= $pekerja['jenis_kelamin'] === 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td class="text-wrap">
                                    <?= esc($pekerja['alamat']) ?>, RT/RW <?= esc($pekerja['rt/rw']) ?>,
                                    Kel. <?= esc($pekerja['desa/kelurahan']) ?>, Kec. <?= esc($pekerja['kecamatan']) ?>,
                                    <?= esc($pekerja['kota_tinggal']) ?> - <?= esc($pekerja['provinsi']) ?> (<?= esc($pekerja['kode_pos']) ?>)
                                </td>
                            </tr>
                            <tr>
                                <th>Pendidikan</th>
                                <td><?= esc($pekerja['pendidikan']) ?> - <?= esc($pekerja['jurusan']) ?></td>
                            </tr>
                            <tr>
                                <th>Gelar</th>
                                <td><?= esc($pekerja['gelar_depan']) == '-' ? '' : esc($pekerja['gelar_depan']) ?> <?= esc($pekerja['nama']) ?><?= esc($pekerja['gelar_belakang']) == '-' ? '' : ', ' . esc($pekerja['gelar_belakang']) ?></td>
                            </tr>
                            <tr>
                                <th>Pekerjaan</th>
                                <td><?= esc($pekerja['pekerjaan']) ?> (<?= esc($pekerja['jenis_pegawai']) ?>)</td>
                            </tr>
                            <tr>
                                <th>Unit Kerja</th>
                                <td><?= esc($pekerja['unit_kerja']) ?></td>
                            </tr>
                            <tr>
                                <th>Tahun & TMT/TST</th>
                                <td>
                                    Tahun: <?= esc($pekerja['tahun']) ?><br>
                                    TMT: <?= date('d-m-Y', strtotime(esc($pekerja['tmt_kerja']))) ?> <br>
                                    TST: <?= date('d-m-Y', strtotime(esc($pekerja['tst_kerja']))) ?>
                                </td>
                            </tr>
                            <tr>
                                <th>File Ijasah</th>
                                <td>
                                    <?php if (!empty($pekerja['ijasah'])): ?>
                                        <a href="<?= base_url('assets/ijasah/' . $pekerja['ijasah']) ?>" target="_blank">Lihat Ijasah</a>
                                    <?php else: ?>
                                        Tidak ada file
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <?php if ($pekerja['status_pekerja'] == 'Terverifikasi'): ?>
                                        <span class="badge bg-success rounded-1"><?= $pekerja['status_pekerja'] ?></span>
                                    <?php elseif ($pekerja['status_pekerja'] == 'Tidak Aktif'): ?>
                                        <span class="badge bg-danger rounded-1"><?= $pekerja['status_pekerja'] ?></span>
                                    <?php elseif ($pekerja['status_pekerja'] == 'Menunggu'): ?>
                                        <span class="badge bg-warning text-dark rounded-1"><?= $pekerja['status_pekerja'] ?></span>
                                    <?php elseif ($pekerja['status_pekerja'] == 'Pensiun'): ?>
                                        <span class="badge bg-dark rounded-1">Pensiun</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php if ($pekerja['status_pekerja'] == 'Tidak Aktif') : ?>
                                <tr>
                                    <th>Keterangan</th>
                                    <td><?= esc($pekerja['keterangan']) ?></td>
                                </tr>
                                <tr>
                                    <th>Tanggal Ubah</th>
                                    <td><?= date('d-m-Y', strtotime(esc($history['updated_at']))) ?></td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    <a href="<?= site_url('data_pekerja') . '/' . session()->get('page') ?>" class="btn btn-secondary">Kembali</a>
                    <!-- show modal verikasi -->
                    <?php if ((session()->get('page') != 'pensiun') && (session()->get('level') == 'admin')) : ?>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#verifikasiModal">Verifikasi</button>
                    <?php endif; ?>
                    <?php if ((session()->get('page') == 'new') && (session()->get('level') == 'user')) : ?>
                        <a href="<?= site_url('data_pekerja/cetak_usulan/' . $id_pekerja_encrypted) ?>" class="btn btn-primary" target="_blank">Cetak Usulan</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- KTP Viewer Card -->
    <div class="col-lg-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Preview KTP</h5>
                <?php if (!empty($pekerja['ktp'])): ?>
                    <?php
                    $ext = strtolower(pathinfo($pekerja['ktp'], PATHINFO_EXTENSION));
                    $file_url = base_url('assets/ktp/' . $pekerja['ktp']);
                    ?>

                    <?php if (in_array($ext, ['jpg', 'jpeg', 'png'])): ?>
                        <img src="<?= $file_url ?>" class="img-fluid" alt="KTP" style="width:100%; max-height: 400px; object-fit: contain;">
                    <?php elseif ($ext === 'pdf'): ?>
                        <iframe src="<?= $file_url ?>" style="width:100%; height:400px;" frameborder="0"></iframe>
                    <?php else: ?>
                        <p>Format file tidak didukung. <a href="<?= $file_url ?>" target="_blank">Download file</a></p>
                    <?php endif; ?>
                <?php else: ?>
                    <p>Tidak ada file KTP.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal Verifikasi -->
<div class="modal fade" id="verifikasiModal" tabindex="-1" aria-labelledby="verifikasiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verifikasiModalLabel">Verifikasi Data Pekerja</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= site_url('data_pekerja/simpan_verifikasi/' . $id_pekerja_encrypted) ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin memverifikasi data pekerja ini?</p>
                    <input type="hidden" name="id_pekerja" value="<?= $pekerja['id_pekerja'] ?>" hidden>
                    <input type="hidden" name="nama" value="<?= $pekerja['nama'] ?>" hidden>
                    <label for="status" class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="" selected disabled>Pilih Status</option>
                        <!-- ambil value terakhir dari database lalu selected -->
                        <option value="Terverifikasi" <?= $pekerja['status_pekerja'] == 'Terverifikasi' ? 'selected' : '' ?>>Aktif</option>
                        <option value="Tidak Aktif" <?= $pekerja['status_pekerja'] == 'Tidak Aktif' ? 'selected' : '' ?>>Tidak Aktif</option>
                    </select>
                    <div class="mb-3 mt-3" id="catatan_container" style="display: none;">
                        <label for="catatan" class="form-label">Catatan</label>
                        <textarea class="form-control" id="catatan" name="keterangan" rows="3" placeholder="Masukkan catatan jika ada..."><?= $pekerja['keterangan'] ?></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Verifikasi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- buat script untuk ketika status tidak aktif baru tampilkan catatan -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusSelect = document.querySelector('select[name="status"]');
        const catatanTextarea = document.querySelector('#catatan_container');

        function toggleCatatan() {
            if (statusSelect.value === 'Tidak Aktif') {
                catatanTextarea.style.display = 'block';
            } else {
                catatanTextarea.style.display = 'none';
            }
        }

        if (statusSelect && catatanTextarea) {
            toggleCatatan(); // Jalankan sekali saat load halaman
            statusSelect.addEventListener('change', toggleCatatan); // Jalankan saat ada perubahan
        }
    });
</script>

<?= $this->endSection() ?>