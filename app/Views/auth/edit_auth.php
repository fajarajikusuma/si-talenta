<?= $this->extend('dashboard/main') ?>
<?= $this->section('content') ?>
<?php session()->set('profile', 'true'); ?>

<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <!-- alert -->
            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <!-- end alert -->

            <h4 class="card-title">Form Edit Data User</h4>
            <p class="card-description">Silakan ubah data yang diperlukan.</p>

            <form class="forms-sample" method="POST" action="<?= site_url('user_update/' . $id_user_encrypted) ?>" enctype="multipart/form-data">
                <?php if (session()->get('level') == 'admin'): ?>
                    <div class="form-group">
                        <label for="input_unit_kerja">Unit Kerja</label>
                        <select name="id_unit_kerja" class="form-select" id="input_unit_kerja">
                            <?php foreach ($unitKerja as $unit): ?>
                                <option value="<?= $unit['id_unit_kerja'] ?>" <?= $unit['id_unit_kerja'] == $user['id_unit_kerja'] ? 'selected' : '' ?>>
                                    <?= esc($unit['unit_kerja']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php endif; ?>
                <div class="form-group">
                    <label for="input_nama">Nama Lengkap</label>
                    <input type="text" class="form-control" id="input_nama" name="nama_lengkap" value="<?= esc($user['nama_lengkap']) ?>">
                </div>

                <div class="form-group">
                    <label for="input_email">Email</label>
                    <input type="email" class="form-control" id="input_email" name="email" value="<?= esc($user['email']) ?>">
                </div>

                <div class="form-group">
                    <label for="input_hp">No HP</label>
                    <input type="text" class="form-control" id="input_hp" name="no_hp" value="<?= esc($user['no_hp']) ?>">
                </div>

                <div class="form-group">
                    <label for="input_alamat">Alamat</label>
                    <textarea class="form-control" id="input_alamat" name="alamat" rows="3"><?= esc($user['alamat']) ?></textarea>
                </div>

                <div class="form-group">
                    <label for="input_foto">Foto</label>
                    <?php if ($user['foto']) : ?>
                        <div class="mt-1 mb-2"><img src="<?= base_url('uploads/user_pict/' . $user['foto']) ?>" width="100" class="rounded"></div>
                    <?php endif; ?>
                    <input type="file" class="form-control" id="input_foto" name="foto">
                </div>

                <div class="form-group">
                    <label for="input_username">Username</label>
                    <input type="text" class="form-control" id="input_username" name="username" value="<?= esc($user['username']) ?>">
                </div>

                <div class="form-group">
                    <label for="input_password">Password <small>(Kosongkan jika tidak ingin mengubah)</small></label>
                    <input type="password" class="form-control" id="input_password" name="password" placeholder="Masukkan Password Baru (Opsional)">
                </div>
                <button type="submit" class="btn btn-primary me-2">Update</button>
                <a href="<?= site_url('user_sistem') ?>" class="btn btn-light">Batal</a>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>