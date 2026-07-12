<?= $this->extend('dashboard/main') ?>
<?= $this->section('content') ?>

<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Detail Nomor SK Tahun <?= esc($noSk['tahun']) ?></h4>

            <div class="alert alert-light border mb-3">
                <div class="row">
                    <div class="col-md-6 mb-2 mb-md-0">
                        <strong>Kode SK:</strong> <?= esc($noSk['kode_sk']) ?>
                    </div>
                    <div class="col-md-6">
                        <strong>Nomor Utama:</strong> <?= esc($noSk['nomor_utama']) ?>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-column flex-md-row gap-2 mb-3">
                <a href="<?= site_url('no-sk/form-generate/' . $id_enc) ?>"
                    class="btn btn-success">
                    <i class="mdi mdi-auto-fix"></i> Generate Nomor SK
                </a>

                <form action="<?= site_url('no-sk/hapus-semua/' . $id_enc) ?>" method="POST" 
                      onsubmit="return confirm('Yakin hapus SEMUA nomor SK? Tindakan ini tidak bisa dibatalkan!')"
                      class="d-inline">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="mdi mdi-delete"></i> Hapus Semua Nomor SK
                    </button>
                </form>
                
                <a href="<?= site_url('no-sk') ?>" class="btn btn-secondary">
                    <i class="mdi mdi-arrow-left"></i> Kembali
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

            <!-- Responsive Table Wrapper -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="tableDataPekerja">
                    <thead class="table-primary">
                        <tr>
                            <th width="150">ID Pegawai</th>
                            <th>Nama</th>
                            <th width="200">Nomor SK</th>
                            <th width="150">Tanggal Penetapan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($listSk as $row): ?>
                            <tr>
                                <td class="align-middle"><?= esc($row['id_pekerja']) ?></td>
                                <td class="align-middle"><?= esc($row['nama']) ?></td>
                                <td class="text-start"><?= esc($row['nomor_sk']) ?></td>
                                <td class="align-middle">
                                    <?= isset($row['tanggal_penetapan']) ? date('d-m-Y', strtotime($row['tanggal_penetapan'])) : '-' ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>