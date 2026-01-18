<?= $this->extend('dashboard/main') ?>
<?= $this->section('content') ?>

<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Edit Nomor SK</h4>

            <form action="<?= site_url('no-sk/update/' . $id_encrypted) ?>" method="post">

                <?= csrf_field() ?>

                <div class="form-group mb-3">
                    <label>Kode SK</label>
                    <input type="text"
                        name="kode_sk"
                        class="form-control"
                        value="<?= esc($data['kode_sk']) ?>"
                        required>
                </div>

                <div class="form-group mb-3">
                    <label>Nomor Utama</label>
                    <input type="text"
                        name="nomor_utama"
                        class="form-control"
                        value="<?= esc($data['nomor_utama']) ?>"
                        required>
                </div>

                <div class="form-group mb-3">
                    <label>Tahun</label>
                    <input type="number"
                        name="tahun"
                        class="form-control"
                        value="<?= esc($data['tahun']) ?>"
                        required>
                </div>


                <button class="btn btn-warning">Update</button>
                <a href="<?= site_url('no-sk') ?>" class="btn btn-light">Kembali</a>
            </form>

        </div>
    </div>
</div>

<?= $this->endSection() ?>