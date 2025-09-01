<?= $this->extend('dashboard/main') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h4 class="card-title m-0 fw-bold"><?= 'Data ' . $subtitle ?></h4>
                <a href="<?= site_url('unit_kerja/add') ?>" class="btn btn-primary"><i class="fa fa-plus-square"></i></a>
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
                <div class="table-responsive">
                    <table class="table table-hover" id="tableDataPekerja">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Unit Kerja</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($unit_kerja as $uk) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $uk['unit_kerja'] ?></td>
                                    <td><?= $uk['detail'] ?></td>
                                    <td>
                                        <div class="d-flex btn-group">
                                            <a href="<?= site_url('unit_kerja/edit/' . $uk['id_unit_kerja_encrypted']) ?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                                            <a href="<?= site_url('unit_kerja/delete/' . $uk['id_unit_kerja_encrypted']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin ingin menghapus data <?= $uk['unit_kerja'] ?> ?')"><i class="fa fa-trash"></i></a>
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

<?= $this->endSection() ?>