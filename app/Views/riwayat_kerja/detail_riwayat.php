<?= $this->extend('dashboard/main') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body d-flex justify-content-start align-items-center gap-2">
                <!-- button back -->
                <?php
                $encrypt = \Config\Services::encrypter();
                $id_pekerja_encrypt = bin2hex($encrypt->encrypt($riwayat['id_pekerja']));
                ?>
                <a href="<?= base_url('riwayat_kerja/riwayat/' . $id_pekerja_encrypt) ?>" class="btn btn-sm btn-secondary">
                    <i class="mdi mdi-arrow-left"></i>
                </a>
                <h4 class="card-title m-0 fw-bold"><?= 'Detail ' . $subtitle ?></h4>
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
                    <table class="table table-hover table-bordered" id="tableDataPekerja1" style="width: 100%; table-layout: fixed;">
                        <thead class="table-light">
                            <tr>
                                <th class="col-2">Field</th>
                                <th>Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Nama Pegawai</td>
                                <td><?= $pekerja['nama'] ?></td>
                            </tr>
                            <tr>
                                <td>Pekerjaan</td>
                                <td><?= $pekerja['pekerjaan'] ?></td>
                            </tr>
                            <tr>
                                <td>Jenis Pegawai</td>
                                <td><?= $pekerja['jenis_pegawai'] ?></td>
                            </tr>
                            <tr>
                                <td>Unit Kerja</td>
                                <td><?= $pekerja['unit_kerja'] ?></td>
                            </tr>
                            <tr>
                                <td>Tahun</td>
                                <td><?= $riwayat['tahun'] ?></td>
                            </tr>
                            <tr>
                                <td>TMT Kerja</td>
                                <td><?= date('d-m-Y', strtotime($riwayat['tmt_kerja'])) ?></td>
                            </tr>
                            <tr>
                                <td>TST Kerja</td>
                                <td><?= date('d-m-Y', strtotime($riwayat['tst_kerja'])) ?></td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td><?= $riwayat['status'] ?></td>
                            </tr>
                            <tr>
                                <td>Gaji</td>
                                <td><?= number_format(floatval($riwayat['gaji']), 0, ',', '.') ?></td>
                            </tr>
                            <tr>
                                <td style="word-wrap: break-word; white-space: pre-wrap; vertical-align: top;">Uraian Pekerjaan</td>
                                <td style="word-wrap: break-word; white-space: pre-wrap; vertical-align: top;"><?= $riwayat['uraian_pekerjaan'] ?></td>
                            </tr>
                            <tr>
                                <td>SK SPT</td>
                                <td>
                                    <?php if ($riwayat['sk_spt']) : ?>
                                        <a href="<?= base_url('uploads/spt/' . $riwayat['sk_spt']) ?>" target="_blank">Lihat</a>
                                    <?php else: ?>
                                        Tidak ada file
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>SK PKS</td>
                                <td>
                                    <?php if ($riwayat['sk_pks']) : ?>
                                        <a href="<?= base_url('uploads/pks/' . $riwayat['sk_pks']) ?>" target="_blank">Lihat</a>
                                    <?php else: ?>
                                        Tidak ada file
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>