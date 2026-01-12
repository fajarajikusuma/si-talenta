<?= $this->extend('dashboard/main') ?>
<?= $this->section('content') ?>

<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Cetak Dokumen SK Tenaga Kegiatan</h4>
            <p class="card-description">Silakan pilih data yang ingin dicetak.</p>
            <!-- buatkan 4 tombol -->
            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <div class="d-flex justify-content-start mb-4 gap-2">
                <a href="<?= site_url('cetak_spt') ?>" class="btn btn-primary">Cetak Surat Perintah Tugas Kolektif</a>
                <a href="<?= site_url('cetak_pks') ?>" class="btn btn-secondary">Cetak Perjanjian Kerjasama Kolektif</a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>