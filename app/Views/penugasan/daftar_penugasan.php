<?= $this->extend('dashboard/main') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h4 class="card-title m-0 fw-bold">Daftar Penugasan Baru</h4>
            </div>
        </div>
    </div>

    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header bg-primary text-white p-4 d-flex justify-content-between align-items-center">
                <h4 class="m-0">Data Pengajuan Penugasan</h4>
                <?php if (session()->get('level') == 'admin'): ?>
                    <div>
                        <input type="checkbox" id="checkAll"> <label for="checkAll" class="mb-0">Check All</label>
                    </div>
                <?php endif; ?>
            </div>
            <?php if (session()->getFlashdata('success')) : ?>
                <div class="alert alert-success alert-dismissible fade show m-0 mt-3 mx-3" role="alert">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php elseif (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger alert-dismissible fade show m-0 mt-3 mx-3" role="alert">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <div class="card-body">
                <?php if (session()->get('level') == 'admin'): ?>
                    <form method="post" action="<?= site_url('cetak_usulan_tugas_baru') ?>">
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <label for="id_unit_kerja" class="form-label"><b>Filter Unit Kerja</b></label>
                                <select name="id_unit_kerja" class="form-select" onchange="this.form.submit()">
                                    <option value="">-- Semua Unit Kerja --</option>
                                    <?php foreach ($unitKerja as $unit): ?>
                                        <?php if ($unit['unit_kerja'] != 'Dinas Lingkungan Hidup') : ?>
                                            <option value="<?= esc($unit['id_unit_kerja']) ?>" <?= (isset($_POST['id_unit_kerja']) && $_POST['id_unit_kerja'] == $unit['id_unit_kerja']) ? 'selected' : '' ?>>
                                                <?= esc($unit['unit_kerja']) ?>
                                            </option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </form>
                <?php endif; ?>
                <form id="formVerifikasi" method="post" action="<?= site_url('verifikasi_penugasan') ?>">
                    <div class="table-responsive">
                        <table id="tableDataPekerja" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <?php if (session()->get('level') == 'admin'): ?>
                                        <th class="text-center">#</th>
                                    <?php endif; ?>
                                    <th class="text-center">No</th>
                                    <th>Nama</th>
                                    <th>Unit Kerja</th>
                                    <th>Pekerjaan</th>
                                    <th>TMT</th>
                                    <th>TST</th>
                                    <th>Tahun</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($dataPekerja as $item): ?>
                                    <tr>
                                        <?php if (session()->get('level') == 'admin'): ?>
                                            <td class="text-center">
                                                <input type="checkbox" name="verifikasi_id[]" value="<?= $item['id'] ?? $no ?>">
                                            </td>
                                        <?php endif; ?>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td><?= esc($item['nama']) ?></td>
                                        <td><?= esc($item['unit_kerja'] ?: 'Tidak Diketahui') ?></td>
                                        <td><?= esc($item['pekerjaan'] ?: 'Tidak Diketahui') ?></td>
                                        <td><?= $item['tmt_kerja'] ? date('d-m-Y', strtotime($item['tmt_kerja'])) : 'Tidak Diketahui' ?></td>
                                        <td><?= $item['tst_kerja'] ? date('d-m-Y', strtotime($item['tst_kerja'])) : 'Tidak Diketahui' ?></td>
                                        <td><?= esc($item['tahun']) ?></td>
                                        <td class="text-center"><span class="badge bg-warning text-dark rounded"><?= esc(ucfirst($item['status'])) ?></span></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-between mt-3">
                        <?php if (session()->get('level') === 'admin') : ?>
                            <button type="submit" class="btn btn-success">
                                <i class="mdi mdi-check"></i> Verifikasi
                            </button>
                        <?php endif; ?>
                        <?php if (session()->get('level') === 'user') : ?>
                            <a href="<?= site_url('cetak_penugasan') ?>" class="btn btn-primary" target="_blank">
                                <i class="mdi mdi-printer"></i> Cetak Penugasan
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPT -->
<script>
    document.getElementById('checkAll').addEventListener('change', function() {
        let checkboxes = document.querySelectorAll('input[name="verifikasi_id[]"]');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });
</script>

<?= $this->endSection() ?>