<?= $this->extend('dashboard/main') ?>
<?= $this->section('content') ?>

<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title"><?= $subtitle ?></h4>
            <p class="card-description">Berikut adalah informasi lengkap dari kepala unit kerja:</p>

            <div class="overflow-auto">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 200px;">NIP</th>
                        <td><?= esc($kepala['nip']) ?></td>
                    </tr>
                    <tr>
                        <th>Nama Kepala</th>
                        <td><?= esc($kepala['nama_kepala']) ?></td>
                    </tr>
                    <tr>
                        <th>Unit Kerja</th>
                        <td><?= esc($nama_unit_kerja['unit_kerja']) ?></td>
                    </tr>
                    <tr>
                        <th>Jabatan Lengkap</th>
                        <td><?= esc($kepala['jabatan']) ?></td>
                    </tr>
                    <tr>
                        <th>Jabatan Pendek</th>
                        <td><?= esc($kepala['jabatan_short']) ?></td>
                    </tr>
                    <tr>
                        <th>Keterangan</th>
                        <td><?= esc($kepala['keterangan']) ?></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <?php if ($kepala['status'] == 'Aktif') : ?>
                                <span class="badge bg-success rounded-1 px-4 py-2">Aktif</span>
                            <?php else : ?>
                                <span class="badge bg-danger rounded-1 px-4 py-2">Tidak Aktif</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </div>

            <a href="<?= site_url('daftar_kepala') ?>" class="btn btn-light mt-3">Kembali</a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>