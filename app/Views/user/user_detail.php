<?= $this->extend('dashboard/main') ?>
<?= $this->section('content') ?>

<div class="row">
    <!-- Bagian Kiri: Detail User -->
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Detail Data User</h4>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th style="width: 30%">Nama Lengkap</th>
                            <td><?= esc($user['nama_lengkap']) ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?= esc($user['email']) ?></td>
                        </tr>
                        <tr>
                            <th>No HP</th>
                            <td><?= esc($user['no_hp']) ?></td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td><?= esc($user['alamat']) ?></td>
                        </tr>
                        <tr>
                            <th>Username</th>
                            <td><?= esc($user['username']) ?></td>
                        </tr>
                        <tr>
                            <th>Level</th>
                            <td>
                                <span class="badge bg-success rounded"><?= strtoupper(esc($user['level'])) ?></span>
                            </td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <?php if ($user['status'] === 'Aktif') : ?>
                                    <span class="badge bg-success rounded">Aktif</span>
                                <?php else : ?>
                                    <span class="badge bg-danger rounded">Nonaktif</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Unit Kerja</th>
                            <td><?= esc($user['unit_kerja']) ?></td>
                        </tr>
                    </table>
                </div>
                <a href="<?= site_url('user_sistem') ?>" class="btn btn-secondary mt-3">Kembali</a>
                <a href="<?= site_url('user_edit/' . $id_user_encrypted) ?>" class="btn btn-primary mt-3">Edit</a>
            </div>
        </div>
    </div>

    <!-- Bagian Kanan: Foto User -->
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body text-center">
                <h5 class="card-title">Foto User</h5>
                <?php if ($user['foto']) : ?>
                    <img src="<?= base_url('uploads/user_pict/' . $user['foto']) ?>" class="img-fluid rounded mb-2" alt="Foto User">
                <?php else : ?>
                    <p class="text-muted">Tidak ada foto.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>