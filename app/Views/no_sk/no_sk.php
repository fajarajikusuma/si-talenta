<?= $this->extend('dashboard/main') ?>
<?= $this->section('content') ?>

<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Nomor SK Tahunan</h4>
            <p class="card-description">Kelola nomor SK utama per tahun.</p>
            <a href="<?= site_url('no-sk/create') ?>" class="btn btn-primary mb-3">
                + Tambah Nomor SK
            </a>
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
                        <th>Tahun</th>
                        <th>Kode SK</th>
                        <th>Nomor Utama</th>
                        <th>Awalan Nomor</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (isset($list) && is_array($list) ? $list : [] as $row): ?>
                        <tr>
                            <td><?= esc($row['tahun']) ?></td>
                            <td><?= esc($row['kode_sk']) ?></td>
                            <td><?= esc($row['nomor_utama']) ?></td>
                            <td><?= esc($row['awalan_nomor']) ?></td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="<?= site_url('no-sk/detail/' . $row['id_no_sk_encrypted']) ?>"
                                        class="btn btn-sm btn-info">
                                        Detail
                                    </a>

                                    <a href="<?= site_url('no-sk/edit/' . $row['id_no_sk_encrypted']) ?>"
                                        class="btn btn-sm btn-warning">
                                        Edit
                                    </a>

                                    <a href="<?= site_url('no-sk/delete/' . $row['id_no_sk_encrypted']) ?>"
                                        class="btn btn-sm btn-danger"
                                        onclick="return confirm('Hapus data?')">
                                        Hapus
                                    </a>
                                </div>
                            </td>

                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

<?= $this->endSection() ?>