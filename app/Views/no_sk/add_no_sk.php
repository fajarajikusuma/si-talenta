<?= $this->extend('dashboard/main') ?>
<?= $this->section('content') ?>

<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Tambah Nomor SK</h4>
            <p class="card-description">
                Buat nomor SK baru berdasarkan nomor buku surat keluar dinas. 
                <strong>Setiap tanggal penetapan harus menggunakan nomor utama yang berbeda.</strong>
            </p>
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
                    <label>Nomor Utama <span class="text-danger">*</span></label>
                    <input type="text"
                        name="nomor_utama"
                        class="form-control"
                        placeholder="Contoh: 0237 (sesuai buku surat keluar)"
                        required>
                    <small class="form-text text-muted">
                        Isikan nomor urut dari <strong>buku surat keluar</strong> dinas untuk tanggal penetapan ini.
                    </small>
                </div>

                <div class="form-group mb-3">
                    <label>Awalan Nomor</label>
                    <input type="number"
                        name="awalan_nomor"
                        class="form-control"
                        placeholder="Isikan 0 jika tidak ada awalan (untuk nomor pertama)"
                        value="0"
                        required>
                    <small class="form-text text-muted">
                        Awalan nomor akan otomatis ter-update saat generate SK. Isi 0 untuk SK pertama kali.
                    </small>
                </div>

                <div class="form-group mb-3">
                    <label>Tanggal Penetapan SK</label>
                    <input type="date"
                        name="tanggal_penetapan"
                        class="form-control"
                        required>
                    <small class="form-text text-muted">
                        ⚠️ <strong>PENTING:</strong> Satu tanggal penetapan = Satu nomor utama (dari buku surat keluar)
                    </small>
                </div>

                <div class="form-group mb-3">
                    <label>Tahun</label>
                    <input type="number"
                        name="tahun"
                        class="form-control" 
                        placeholder="Contoh: 2026"
                        value="<?= date('Y') ?>"
                        required>
                </div>


                <button class="btn btn-primary">Simpan</button>
                <a href="<?= site_url('no-sk') ?>" class="btn btn-light">Kembali</a>
            </form>

        </div>
    </div>
</div>

<?= $this->endSection() ?>