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
            <h4 class="card-title">Form Tambah Data <?= $subtitle ?></h4>
            <p class="card-description"> Tolong Inputkan Semua Data Dengan Benar!!! </p>
            <form class="forms-sample" method="POST" action="<?= site_url('unit_kerja/store') ?>">
                <div class="form-group">
                    <label for="input_unit_kerja">Nama Unit Kerja</label>
                    <input type="text" class="form-control" id="input_unit_kerja" placeholder="Masukan Nama Unit Kerja" name="unit_kerja">
                </div>
                <div class="form-group">
                    <label for="input_keterangan">Keterangan</label>
                    <input type="text" class="form-control" id="input_keterangan" placeholder="Masukan Keterangan" name="keterangan">
                </div>
                <button type=" submit" class="btn btn-primary me-2">Simpan</button>
                <a href="<?= site_url('unit_kerja') ?>" class="btn btn-light">Batal</a>
            </form>
        </div>
    </div>
</div>



<?= $this->endSection() ?>