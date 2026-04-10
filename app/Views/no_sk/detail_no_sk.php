<?= $this->extend('dashboard/main') ?>
<?= $this->section('content') ?>

<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Detail Nomor SK Tahun <?= esc($noSk['tahun']) ?></h4>

            <div class="mb-3">
                <strong>Kode SK:</strong> <?= esc($noSk['kode_sk']) ?><br>
                <strong>Nomor Utama:</strong> <?= esc($noSk['nomor_utama']) ?>
            </div>


            <div class="d-flex gap-2 mb-3">
                <a href="<?= site_url('no-sk/generate/' . $id_enc) ?>"
                    class="btn btn-success"
                    onclick="return confirm('Generate ulang nomor SK?')">
                    Generate Nomor SK
                </a>

                <a href="<?= site_url('no-sk/hapus-semua/' . $id_enc) ?>"
                    class="btn btn-danger"
                    onclick="return confirm('Yakin hapus SEMUA nomor SK? Tindakan ini tidak bisa dibatalkan!')">
                    Hapus Semua Nomor SK
                </a>
            </div>


            <?php if (session()->getFlashdata('success')) : ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <table class="table table-bordered" id="tableDataPekerja">
                <thead>
                    <tr>
                        <th>ID Pegawai</th>
                        <th>Nama</th>
                        <th>Nomor SK</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($listSk as $row): ?>
                        <tr>
                            <td><?= esc($row['id_pekerja']) ?></td>
                            <td><?= esc($row['nama']) ?></td>
                            <td class="text-start"><?= esc($row['nomor_sk']) ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

<?= $this->endSection() ?>