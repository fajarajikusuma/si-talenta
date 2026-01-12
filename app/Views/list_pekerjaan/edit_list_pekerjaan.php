<?= $this->extend('dashboard/main') ?>
<?= $this->section('content') ?>

<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Form Edit Data <?= $subtitle ?></h4>
            <p class="card-description">Silakan perbarui data di bawah ini.</p>
            <form class="forms-sample" method="POST" action="<?= site_url('list_pekerjaan/update/' . $id_list_pekerjaan_encrypted) ?>">
                <div class="form-group">
                    <label for="input_pekerjaan">Pekerjaan</label>
                    <input type="text" class="form-control" id="input_pekerjaan" placeholder="Masukan Nama Pekerjaan" name="pekerjaan" value="<?= esc($pekerjaan['pekerjaan']) ?>">
                </div>
                <div class="form-group">
                    <label for="input_uraian">Uraian Kerja</label>
                    <textarea class="form-control h-auto" id="input_uraian" placeholder="Masukan Uraian Kerja" name="uraian_kerja"><?= esc($pekerjaan['uraian_kerja']) ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary me-2">Simpan</button>
                <a href="<?= site_url('list_pekerjaan') ?>" class="btn btn-light">Batal</a>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>