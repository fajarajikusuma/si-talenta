<?= $this->extend('dashboard/main') ?>
<?= $this->section('content') ?>

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

            <h4 class="card-title">Form Tambah Data User</h4>
            <p class="card-description">Tolong Inputkan Semua Data Dengan Benar!!!</p>

            <form class="form-sample" method="POST" action="<?= site_url('store_user') ?>" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="input_unit_kerja">Unit Kerja</label>
                    <select name="id_unit_kerja" class="form-select" id="input_unit_kerja">
                        <option value="" disabled <?= old('id_unit_kerja') ? '' : 'selected' ?>>-- Pilih Unit Kerja --</option>
                        <?php foreach ($unitKerja as $unit): ?>
                            <option value="<?= $unit['id_unit_kerja'] ?>" <?= old('id_unit_kerja') == $unit['id_unit_kerja'] ? 'selected' : '' ?>>
                                <?= esc($unit['unit_kerja']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="input_nama">Nama Lengkap</label>
                    <input type="text" class="form-control" id="input_nama" name="nama_lengkap" placeholder="Masukkan Nama Lengkap" value="<?= old('nama_lengkap') ?>">
                </div>

                <div class="form-group">
                    <label for="input_email">Email</label>
                    <input type="email" class="form-control" id="input_email" name="email" placeholder="Masukkan Email" value="<?= old('email') ?>">
                </div>

                <div class="form-group">
                    <label for="input_hp">No HP</label>
                    <input type="text" class="form-control" id="input_hp" name="no_hp" placeholder="Masukkan No HP" value="<?= old('no_hp') ?>">
                </div>

                <div class="form-group">
                    <label for="input_alamat">Alamat</label>
                    <textarea class="form-control" id="input_alamat" name="alamat" rows="3" placeholder="Masukkan Alamat"><?= old('alamat') ?></textarea>
                </div>

                <div class="form-group">
                    <label for="input_foto">Foto</label>
                    <input type="file" class="form-control" id="input_foto" name="foto">
                </div>

                <div class="form-group">
                    <label for="input_username">Username</label>
                    <input type="text" class="form-control" id="input_username" name="username" placeholder="Masukkan Username" value="<?= old('username') ?>">
                </div>

                <div class="form-group">
                    <label for="input_password">Password</label>
                    <input type="password" class="form-control" id="input_password" name="password" placeholder="Masukkan Password">
                </div>

                <div class="form-group">
                    <label for="input_level">Level</label>
                    <select class="form-select" name="level" id="input_level">
                        <option value="" disabled <?= old('level') ? '' : 'selected' ?>>-- Pilih Level --</option>
                        <option value="admin" <?= old('level') == 'admin' ? 'selected' : '' ?>>Admin</option>
                        <option value="user" <?= old('level') == 'user' ? 'selected' : '' ?>>User</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="input_status">Status</label>
                    <select class="form-select" name="status" id="input_status">
                        <option value="" disabled <?= old('status') ? '' : 'selected' ?>>-- Pilih Status --</option>
                        <option value="aktif" <?= old('status') == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                        <option value="nonaktif" <?= old('status') == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary me-2">Simpan</button>
                <a href="<?= site_url('user_sistem') ?>" class="btn btn-light">Batal</a>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>