<?= $this->extend('dashboard/main') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h4 class="card-title m-0 fw-bold">Data User</h4>
                <a href="<?= site_url('add_user') ?>" class="btn btn-primary">Tambah User</a>
            </div>
        </div>
    </div>

    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <?php if (session()->getFlashdata('success')) : ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('error')) : ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="table-responsive">
                    <table class="table table-bordered" id="tableDataPekerja">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Foto</th>
                                <th>Nama Lengkap</th>
                                <th>No HP</th>
                                <th>Unit Kerja</th>
                                <th>Level</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($users as $u): ?>
                                <tr>
                                    <td><?= esc($no++) ?></td>
                                    <td>
                                        <?php if ($u['foto']) : ?>
                                            <img src="<?= base_url('uploads/user_pict/' . $u['foto']) ?>" width="50">
                                        <?php endif ?>
                                    </td>
                                    <td><?= esc($u['nama_lengkap']) ?></td>
                                    <td><?= esc($u['no_hp']) ?></td>
                                    <td><?= esc($u['unit_kerja']) ?></td>
                                    <!-- buat level dengan badge -->
                                    <td>
                                        <?php if ($u['level'] == 'admin'): ?>
                                            <span class="badge bg-success rounded"><?= strtoupper(esc($u['level'])) ?></span>
                                        <?php elseif ($u['level'] == 'user'): ?>
                                            <span class="badge bg-primary rounded"><?= strtoupper(esc($u['level'])) ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary rounded"><?= strtoupper(esc($u['level'])) ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <!-- buat status dengan badge -->
                                    <td>
                                        <?php if ($u['status'] == 'Aktif'): ?>
                                            <span class="badge bg-success rounded"><?= strtoupper(esc($u['status'])) ?></span>
                                        <?php elseif ($u['status'] == 'Tidak Aktif'): ?>
                                            <span class="badge bg-danger rounded"><?= strtoupper(esc($u['status'])) ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group d-flex">
                                            <!-- detail -->
                                            <a href="<?= site_url('user_detail/' . $u['id_user_encrypted']) ?>" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a>
                                            <a href="<?= site_url('user_edit/' . $u['id_user_encrypted']) ?>" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
                                            <a href="<?= site_url('user_delete/' . $u['id_user_encrypted']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin hapus?')"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>