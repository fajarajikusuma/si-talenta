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

            <h4 class="card-title">Form Edit Data <?= $subtitle ?></h4>
            <p class="card-description">Silakan ubah data yang perlu diperbaiki</p>

            <form class="forms-sample" method="POST" action="<?= site_url('daftar_kepala/update/' . $id_kepala_encrypted) ?>">
                <div class="form-group">
                    <label for="input_nip">NIP</label>
                    <input type="text" class="form-control" id="input_nip" placeholder="Masukan NIP" name="nip" minlength="18" maxlength="18" value="<?= esc($daftar_kepala['nip']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="input_nama_kepala">Nama Kepala</label>
                    <input type="text" class="form-control" id="input_nama_kepala" placeholder="Masukan Nama Kepala" name="nama_kepala" value="<?= esc($daftar_kepala['nama_kepala']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="input_unit_kerja">Nama Unit Kerja</label>
                    <select class="form-control" id="input_unit_kerja" name="unit_kerja" required>
                        <option value="" disabled>-- Pilih Unit Kerja --</option>
                        <?php foreach ($unit_kerja as $row) : ?>
                            <option value="<?= esc($row['id_unit_kerja']) ?>" <?= $row['id_unit_kerja'] == $daftar_kepala['id_unit_kerja'] ? 'selected' : '' ?>>
                                <?= esc($row['unit_kerja']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="input_jabatan">Jabatan Lengkap</label>
                    <input type="text" class="form-control" id="input_jabatan" placeholder="Masukan Jabatan" name="jabatan" value="<?= esc($daftar_kepala['jabatan']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="input_jabatan_short">Jabatan Pendek</label>
                    <input type="text" class="form-control" id="input_jabatan_short" placeholder="Masukan Jabatan" name="jabatan_short" value="<?= esc($daftar_kepala['jabatan_short']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="input_keterangan">Keterangan</label>
                    <input type="text" class="form-control" id="input_keterangan" placeholder="Masukan Keterangan" name="keterangan" value="<?= esc($daftar_kepala['keterangan']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="input_status">Status</label>
                    <select class="form-control" id="input_status" name="status" required>
                        <option value="" disabled>-- Pilih Status --</option>
                        <option value="Aktif" <?= $daftar_kepala['status'] == 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                        <option value="Tidak Aktif" <?= $daftar_kepala['status'] == 'Tidak Aktif' ? 'selected' : '' ?>>Nonaktif</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary me-2">Simpan</button>
                <a href="<?= site_url('daftar_kepala') ?>" class="btn btn-light">Batal</a>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>