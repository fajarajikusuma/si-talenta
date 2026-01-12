<?= $this->extend('dashboard/main') ?>
<?= $this->section('content') ?>

<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Form Edit Data <?= $subtitle ?></h4>
            <p class="card-description">Silakan perbarui data di bawah ini.</p>
            <form class="forms-sample" method="POST" action="<?= site_url('unit_kerja/update/' . $id_unit_kerja_encrypted) ?>">
                <div class="form-group">
                    <label for="input_unit_kerja">Nama Unit Kerja</label>
                    <input type="text" class="form-control" id="input_unit_kerja" placeholder="Masukan Nama Unit Kerja" name="unit_kerja" value="<?= esc($unit_kerja['unit_kerja']) ?>">
                </div>
                <div class="form-group">
                    <label for="input_keterangan">Keterangan</label>
                    <input type="text" class="form-control" id="input_keterangan" placeholder="Masukan Keterangan" name="keterangan" value="<?= esc($unit_kerja['detail']) ?>">
                </div>
                <button type="submit" class="btn btn-primary me-2">Simpan</button>
                <a href="<?= site_url('unit_kerja') ?>" class="btn btn-light">Batal</a>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>