<?= $this->extend('dashboard/main') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h4 class="card-title m-0 fw-bold"><?= 'Data ' . $subtitle ?></h4>
                <!-- jika url data_pekerja/new baru munculkan tombol dibawah -->
                <?php if (uri_string() == 'data_pekerja/new') : ?>
                    <a href="<?= site_url('data_pekerja/add') ?>" class="btn btn-primary"><i class="fa fa-plus-square"></i></a>
                <?php endif; ?>
                <?php if (uri_string() == 'data_pekerja/aktif') : ?>
                    <!-- button to show modal import data pekerja -->
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-upload me-2"></i>Import
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#importDataPekerjaModal">Import Data Tenaga Kerja</a></li>
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalInputRiwayatKerja">Import Riwayat Kerja Terdahulu</a></li>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php if (uri_string() == 'data_pekerja/pensiun') : ?>
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <?php
                    $tahunSekarang = date('Y');
                    $tahunDipilih = isset($_GET['tahun_cari']) ? $_GET['tahun_cari'] : $tahunSekarang;
                    ?>

                    <form action="<?= site_url('data_pekerja/pensiun') ?>" method="get">
                        <div class="d-flex align-items-center gap-3">
                            <label for="tahun" class="mb-0">Pilih Tahun</label>
                            <select name="tahun_cari" id="tahun" class="form-select" onchange="this.form.submit()" style="width: auto;">
                                <?php for ($i = $tahunSekarang - 50; $i <= $tahunSekarang + 50; $i++) : ?>
                                    <option value="<?= $i ?>" <?= ($tahunDipilih == $i) ? 'selected' : '' ?>><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
        $tahunSekarang = date('Y');
        $tahunCari = !empty($_GET['tahun_cari']) ? $_GET['tahun_cari'] : $tahunSekarang;
        ?>
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-2">Data Pekerja Akan Pensiun Tahun <?= $tahunCari ?></h4>
                    <!-- total data -->
                    <p class="text-muted">Total pegawai yang akan pensiun di tahun <?= $tahunCari ?>: <strong style="color: red;"><?= array_sum(array_column($data_bulanan, 'total')) ?> Orang</strong></p>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Bulan</th>
                                    <th>Total</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data_bulanan as $bulan => $info): ?>
                                    <tr>
                                        <td><?= $info['nama_bulan'] ?></td>
                                        <td><?= $info['total'] ?></td>
                                        <td>
                                            <?php
                                            if ($info['total'] > 0): ?>
                                                <button class="btn btn-primary btn-sm btn-lihat-pensiun"
                                                    data-bulan="<?= $bulan ?>"
                                                    data-tahun="<?= $tahun_cari == NULL ? date('Y') : $tahun_cari ?>"
                                                    data-nama="<?= $info['nama_bulan'] ?>">
                                                    Lihat
                                                </button>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <p class="text-muted mt-2">Klik tombol "Lihat" untuk melihat detail pegawai yang pensiun di bulan tersebut.</p>
                </div>
            </div>
        </div>

    <?php endif; ?>

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
                                <th>Nama Pegawai</th>
                                <th>Jenis Kelamin</th>
                                <th>Pekerjaan</th>
                                <th>Unit Kerja</th>
                                <?php if (uri_string() == 'data_pekerja/aktif' || uri_string() == 'data_pekerja/pensiun') : ?>
                                    <th>TMT Kerja</th>
                                <?php endif; ?>
                                <?php if (uri_string() == 'data_pekerja/pensiun') : ?>
                                    <th>Tanggal Pensiun</th>
                                <?php endif; ?>
                                <?php if (uri_string() == 'data_pekerja/aktif' || uri_string() == 'data_pekerja/new' || uri_string() == 'data_pekerja/out') : ?>
                                    <th class="text-center">Status</th>
                                <?php endif; ?>
                                <?php if (uri_string() == 'data_pekerja/new') : ?>
                                    <th>Tanggal Input</th>
                                <?php endif; ?>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($data_pekerja as $dp) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $dp['nama'] ?></td>
                                    <td><?= $dp['jenis_kelamin'] == 'L' ? 'Laki-Laki' : 'Perempuan' ?></td>
                                    <td><?= $dp['pekerjaan'] ?></td>
                                    <td><?= $dp['unit_kerja'] ?></td>
                                    <?php if (uri_string() == 'data_pekerja/aktif' || uri_string() == 'data_pekerja/pensiun') : ?>
                                        <td><?= date('d-m-Y', strtotime($dp['tmt_kerja'])) ?></td>
                                    <?php endif; ?>
                                    <?php if (uri_string() == 'data_pekerja/pensiun') : ?>
                                        <td class="text-center"><?= date('d-m-Y', strtotime($dp['tanggal_pensiun'])) ?></td>
                                    <?php endif; ?>
                                    <?php if (uri_string() == 'data_pekerja/aktif' || uri_string() == 'data_pekerja/new' || uri_string() == 'data_pekerja/out') : ?>
                                        <td class="text-center">
                                            <?php if ($dp['status_pekerja'] == 'Terverifikasi') : ?>
                                                <span class="badge bg-success rounded-1"><?= $dp['status_pekerja'] ?></span>
                                            <?php elseif ($dp['status_pekerja'] == 'Tidak Aktif') : ?>
                                                <span class="badge bg-danger rounded-1"><?= $dp['status_pekerja'] ?></span>
                                            <?php elseif ($dp['status_pekerja'] == 'Menunggu') : ?>
                                                <span class="badge bg-warning text-dark rounded-1"><?= $dp['status_pekerja'] ?></span>
                                                <!-- jika usia lebih dari sama dengan 58 maka tampilkan badge status_pekerja pensiun -->
                                            <?php elseif ($dp['tanggal_pensiun'] <= date('Y-m-d')) : ?>
                                                <span class="badge bg-danger rounded-1">Pensiun</span>
                                            <?php endif; ?>
                                        </td>
                                    <?php endif; ?>
                                    <?php if (uri_string() == 'data_pekerja/new') : ?>
                                        <td class="text-center"><?= date('d-m-Y', strtotime($dp['created_at'])) ?></td>
                                    <?php endif; ?>
                                    <td>
                                        <div class="d-flex btn-group">
                                            <a href="<?= site_url('data_pekerja/detail/' . $dp['id_pekerja_encrypted']) ?>" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                                            <?php if ($dp['status_pekerja'] != 'Menunggu') : ?>
                                                <a href="<?= site_url('riwayat_kerja/riwayat/' . $dp['id_pekerja_encrypted']) ?>" class="btn btn-primary btn-sm"><i class="fa fa-history"></i></a>
                                            <?php endif; ?>
                                            <?php
                                            $status = strtolower(trim($dp['status_pekerja']));
                                            $level = session()->get('level');
                                            ?>

                                            <?php if ($status == 'menunggu' || $status == 'terverifikasi') : ?>
                                                <a href="<?= site_url('data_pekerja/edit/' . $dp['id_pekerja_encrypted']) ?>" class="btn btn-warning btn-sm">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <?php if ($level == 'admin') : ?>
                                                    <a href="<?= site_url('data_pekerja/delete/' . $dp['id_pekerja_encrypted']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                <?php endif; ?>
                                                <?php if ($level != 'admin' && $status == 'menunggu') : ?>
                                                    <a href="<?= site_url('data_pekerja/delete/' . $dp['id_pekerja_encrypted']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                <?php endif; ?>
                                            <?php endif; ?>
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

<!-- Modal Import Data Pekerja -->
<div class="modal fade" id="importDataPekerjaModal" tabindex="-1" aria-labelledby="importDataPekerjaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importDataPekerjaModalLabel">Import Data Pekerja</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= site_url('data_pekerja/import_excel') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="file_excel" class="form-label">File Excel</label>
                        <input type="file" class="form-control" id="file_excel" name="file_excel" accept=".xlsx, .xls, .csv, .ods, .xlsm, .xlsb, .xltx, .xltm, .xltb, .xlam, .xla, .xlw, .xlr, .xlc, .xlm, .xltm, .xltb, .xltc, .xltp, .xltv, .xltw" required>
                    </div>
                    <p>Download template: <a href="<?= site_url('data_pekerja/download_template') ?>" class="btn btn-primary btn-sm"><i class="fa fa-download"></i> Template</a></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Input Excel Riwayat Kerja Terdahulu -->
<div class="modal fade" id="modalInputRiwayatKerja" tabindex="-1" aria-labelledby="modalInputRiwayatKerjaLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalInputRiwayatKerjaLabel">Import Riwayat Kerja Terdahulu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= site_url('riwayat_kerja/import_excel') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="file_excel_riwayat" class="form-label">File Excel</label>
                        <input type="file" class="form-control" id="file_excel_riwayat" name="file_excel_riwayat" accept=".xlsx, .xls, .csv, .ods, .xlsm, .xlsb, .xltx, .xltm, .xltb, .xlam, .xla, .xlw, .xlr, .xlc, .xlm, .xltm, .xltb, .xltc, .xltp, .xltv, .xltw" required>
                    </div>
                    <p>Download template: <a href="<?= site_url('riwayat_kerja/download_template') ?>" class="btn btn-primary btn-sm"><i class="fa fa-download"></i> Template</a></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Pensiun -->
<div class="modal fade" id="modalPensiun" tabindex="-1" aria-labelledby="modalPensiunLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPensiunLabel">Detail Pegawai Pensiun</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div id="modal-content-pensiun">Memuat data...</div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on('click', '.btn-lihat-pensiun', function() {
        const bulan = $(this).data('bulan');
        const tahun = $(this).data('tahun');
        const nama_bulan = $(this).data('nama');

        $('#modalPensiunLabel').text('Pegawai Pensiun Bulan ' + nama_bulan + ' Tahun ' + tahun);
        $('#modal-content-pensiun').html('Memuat data...');

        $.ajax({
            url: "<?= site_url('data_pekerja/ajax_detail_pensiun') ?>",
            method: "GET",
            data: {
                bulan,
                tahun
            },
            success: function(response) {
                $('#modal-content-pensiun').html(response);
            },
            error: function() {
                $('#modal-content-pensiun').html('<p class="text-danger">Gagal memuat data.</p>');
            }
        });

        $('#modalPensiun').modal('show');
    });
</script>

<?= $this->endSection() ?>