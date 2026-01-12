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

            <h4 class="card-title">Form Tambah Data <?= $title ?></h4>
            <p class="card-description">Tolong inputkan semua data dengan benar!</p>

            <form class="forms-sample" method="POST" action="<?= site_url('dasar_hukum/store') ?>" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label for="input_nama_dasar_hukum">Nama Dasar Hukum</label>
                    <input type="text" class="form-control" id="input_nama_dasar_hukum" placeholder="Masukan Nama Dasar Hukum" name="nama_dasar_hukum" minlength="2" maxlength="20" value="<?= old('nama_dasar_hukum') ?>" required>
                </div>
                <div class="form-group">
                    <label for="input_nomor">Nomor</label>
                    <input type="text" class="form-control" id="input_nomor" placeholder="Masukan Nomor" name="nomor" value="<?= old('nomor') ?>" required>
                </div>
                <div class="form-group">
                    <label for="input_tahun">Tahun</label>
                    <select class="form-control" id="input_tahun" name="tahun" required>
                        <option value="" disabled selected>-- Pilih Tahun --</option>
                        <?php for ($i = date('Y') + 10; $i >= 1900; $i--) : ?>
                            <option value="<?= $i ?>" <?= old('tahun') == $i ? 'selected' : '' ?>><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="input_tentang">Tentang</label>
                    <input type="text" class="form-control" id="input_tentang" placeholder="Masukan Tentang" name="tentang" value="<?= old('tentang') ?>" required>
                </div>
                <div class="form-group">
                    <label for="input_file">Upload File</label>
                    <input type="file" class="form-control" id="input_file" name="upload_dokumen" required>
                </div>
                <div class="form-group">
                    <label for="input_status">Status</label>
                    <select class="form-control" id="input_status" name="status">
                        <option value="" disabled selected>-- Pilih Status --</option>
                        <option value="Tidak Aktif">Nonaktif</option>
                        <option value="Aktif 1">Aktif 1</option>
                        <option value="Aktif 2">Aktif 2</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary me-2">Simpan</button>
                <a href="<?= site_url('dasar_hukum') ?>" class="btn btn-light">Batal</a>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>