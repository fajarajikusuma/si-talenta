<?= $this->extend('dashboard/main') ?>
<?= $this->section('content') ?>

<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Tambah Nomor SK</h4>
            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <form action="<?= site_url('no-sk/store') ?>" method="post">
                <?= csrf_field() ?>
                <div class="form-group mb-3">
                    <label>Kode SK</label>
                    <input type="text"
                        name="kode_sk"
                        class="form-control"
                        placeholder="Contoh: 800.1.2"
                        required>
                </div>

                <div class="form-group mb-3">
                    <label>Nomor Utama</label>
                    <input type="text"
                        name="nomor_utama"
                        class="form-control"
                        placeholder="Contoh: 123"
                        required>
                </div>

                <div class="form-group mb-3">
                    <label>Tahun</label>
                    <input type="number"
                        name="tahun"
                        class="form-control"
                        required>
                </div>


                <button class="btn btn-primary">Simpan</button>
                <a href="<?= site_url('no-sk') ?>" class="btn btn-light">Kembali</a>
            </form>

        </div>
    </div>
</div>

<?= $this->endSection() ?>