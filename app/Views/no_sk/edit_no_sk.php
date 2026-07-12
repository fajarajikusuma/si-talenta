<?= $this->extend('dashboard/main') ?>
<?= $this->section('content') ?>

<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Edit Nomor SK</h4>
            <p class="card-description">
                <strong class="text-warning">⚠️ Perhatian:</strong> Mengubah nomor utama atau tanggal penetapan 
                akan mempengaruhi SK yang sudah digenerate. Pastikan tidak ada duplikasi nomor!
            </p>
            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

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
                    <small class="form-text text-muted">
                        Nomor dari buku surat keluar dinas
                    </small>
                </div>

                <div class="form-group mb-3">
                    <label>Awalan Nomor</label>
                    <input type="number"
                        name="awalan_nomor"
                        class="form-control"
                        value="<?= esc($data['awalan_nomor']) ?>">
                    <small class="form-text text-muted">
                        Jumlah SK yang sudah digenerate (otomatis ter-update)
                    </small>
                </div>

                <div class="form-group mb-3">
                    <label>Tanggal Penetapan SK</label>
                    <input type="date"
                        name="tanggal_penetapan"
                        class="form-control"
                        value="<?= esc($data['tanggal_penetapan'] ?? date('Y-m-d')) ?>"
                        required>
                    <small class="form-text text-muted">
                        ⚠️ Ubah dengan hati-hati! Pastikan tidak duplikasi nomor utama
                    </small>
                </div>

                <div class="form-group mb-3">
                    <label>Tahun</label>
                    <input type="number"
                        name="tahun"
                        class="form-control"
                        value="<?= esc($data['tahun']) ?>"
                        placeholder="Contoh: 2025"
                        required>
                </div>


                <button class="btn btn-warning">Update</button>
                <a href="<?= site_url('no-sk') ?>" class="btn btn-light">Kembali</a>
            </form>

        </div>
    </div>
</div>

<?= $this->endSection() ?>