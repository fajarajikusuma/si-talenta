<?= $this->extend('dashboard/main') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center justify-content-between">
                    <div class="col-md-6 col-12 mb-2 mb-md-0">
                        <h4 class="card-title m-0 fw-bold"><?= 'Data ' . $subtitle ?></h4>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="d-flex button-wrapper justify-content-end gap-2">
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importExcelModal">
                                <i class="fa fa-upload me-2"></i> Import Excel
                            </button>
                            <a href="<?= site_url('list_pekerjaan/add') ?>" class="btn btn-primary">
                                <i class="fa fa-plus-square"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"><?= 'Tabel ' . $subtitle ?></h4>
                <?php if (session()->getFlashdata('success')) : ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('error')) : ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <div class="table-responsive">
                    <table class="table table-hover" id="tableDataPekerja">
                        <thead>
                            <tr>
                                <th class="text-start">No</th>
                                <th>Nama Pekerjaan</th>
                                <th>Uraian Kerja</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($list_pekerjaan as $row) : ?>
                                <tr>
                                    <td class="text-start"><?= $no++ ?></td>
                                    <td><?= $row['pekerjaan'] ?></td>
                                    <td><?= $row['uraian_kerja'] ?></td>
                                    <td>
                                        <div class="d-flex btn-group">
                                            <a href="<?= site_url('list_pekerjaan/edit/' . $row['id_list_pekerjaan_encrypted']) ?>" class="btn btn-warning btn-sm">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a href="<?= site_url('list_pekerjaan/delete/' . $row['id_list_pekerjaan_encrypted']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin ingin menghapus data <?= $row['pekerjaan'] ?> ?')">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="importExcelModal" tabindex="-1" aria-labelledby="importExcelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importExcelModalLabel">Import Data Pekerjaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action=" <?= site_url('list_pekerjaan/import_excel') ?>" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="file_excel" class="form-label">Pilih File Excel</label>
                        <input type="file" class="form-control" id="file_excel" name="file_excel" accept=".xls, .xlsx" required>
                    </div>
                    <div class="col-md-12 col-12">
                        <div class="d-flex justify-content-start gap-2">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-upload me-2"></i> Import</button>
                            <!-- button to download template -->
                            <a href="<?= base_url('list_pekerjaan/download_template') ?>" class="btn btn-secondary"><i class="fa fa-download me-2"></i> Download Template</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>