<?= $this->extend('dashboard/main') ?>
<?= $this->section('content') ?>

<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Nomor SK Tahunan</h4>
            <p class="card-description">
                Kelola nomor SK berdasarkan tanggal penetapan. 
                <span class="badge bg-info">💡 Satu tanggal = Satu nomor utama</span>
            </p>
            <a href="<?= site_url('no-sk/create') ?>" class="btn btn-primary mb-3">
                <i class="mdi mdi-plus"></i> Tambah Nomor SK
            </a>
            
            <!-- Responsive Table Wrapper -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="tableDataPekerja">
                    <thead class="table-primary">
                        <tr>
                            <th width="80">Tahun</th>
                            <th width="150">Tanggal Penetapan</th>
                            <th width="100">Kode SK</th>
                            <th>Nomor Utama</th>
                            <th>Awalan Nomor</th>
                            <th width="120" class="text-center">Jumlah SK</th>
                            <th width="200" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (isset($list) && is_array($list) ? $list : [] as $row): ?>
                            <tr>
                                <td class="align-middle"><?= esc($row['tahun']) ?></td>
                                <td class="align-middle">
                                    <?php 
                                    $tglPenetapan = $row['tanggal_penetapan'] ?? null;
                                    echo $tglPenetapan ? date('d-m-Y', strtotime($tglPenetapan)) : '-';
                                    ?>
                                </td>
                                <td class="align-middle"><?= esc($row['kode_sk']) ?></td>
                                <td class="align-middle"><strong><?= esc($row['nomor_utama']) ?></strong></td>
                                <td class="align-middle"><strong><?= esc($row['awalan_nomor']) ?></strong></td>
                                <td class="text-center align-middle">
                                    <span class="badge bg-success">
                                        <?= isset($row['jumlah_sk']) ? esc($row['jumlah_sk']) : 0 ?> SK
                                    </span>
                                </td>
                                <td class="text-center align-middle">
                                    <div class="d-flex justify-content-center" style="gap:2px;">
                                        <a href="<?= site_url('no-sk/detail/' . $row['id_no_sk_encrypted']) ?>"
                                            class="btn btn-sm btn-info"
                                            title="Detail">
                                            <i class="mdi mdi-eye"></i>
                                        </a>

                                        <a href="<?= site_url('no-sk/edit/' . $row['id_no_sk_encrypted']) ?>"
                                            class="btn btn-sm btn-warning"
                                            title="Edit">
                                            <i class="mdi mdi-pencil"></i>
                                        </a>

                                        <form action="<?= site_url('no-sk/delete/' . $row['id_no_sk_encrypted']) ?>" method="post" style="display:contents" data-label="Nomor SK <?= esc($row['kode_sk']) ?> Tahun <?= esc($row['tahun']) ?>">>
                                            <?= csrf_field() ?>
                                            <button type="submit"
                                                class="btn btn-sm btn-danger"
                                                title="Hapus">
                                                <i class="mdi mdi-delete"></i>
                                            </button>
                                        </form>
                                    </div>
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