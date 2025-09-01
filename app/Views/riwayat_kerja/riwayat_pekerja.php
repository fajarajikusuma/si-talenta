<?= $this->extend('dashboard/main') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h4 class="card-title m-0 fw-bold">Riwayat Pekerjaan - <?= esc($pekerja['nama']) ?></h4>
                <?php if ($pekerja['status_pekerja'] == 'Terverifikasi'): ?>
                    <a href="<?= site_url('riwayat_kerja/add/' . $id_pekerja_encrypted) ?>" class="btn btn-success"><i class="fa fa-plus"></i></a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tabel Riwayat Pekerjaan</h4>

                <?php if (session()->getFlashdata('success')) : ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php elseif (session()->getFlashdata('error')) : ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="table-responsive">
                    <table class="table table-hover" id="tableDataPekerja">
                        <thead>
                            <tr>
                                <th>Tahun</th>
                                <th>Pekerjaan</th>
                                <th>Jenis Pegawai</th>
                                <th>Unit Kerja</th>
                                <th>TMT</th>
                                <th>TST</th>
                                <th>Status</th>
                                <th>SPT</th>
                                <th>PKS</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($riwayat as $r) : ?>
                                <tr>
                                    <td><?= esc($r['tahun']) ?></td>
                                    <td><?= esc($r['pekerjaan']) ?></td>
                                    <td><?= esc($r['jenis_pegawai']) ?></td>
                                    <td><?= esc($r['unit_kerja']) ?></td>
                                    <td><?= date('d-m-Y', strtotime($r['tmt_kerja'])) ?></td>
                                    <td><?= $r['tst_kerja'] ? date('d-m-Y', strtotime($r['tst_kerja'])) : '-' ?></td>
                                    <td>
                                        <?php if ($r['status'] == 'Terverifikasi') : ?>
                                            <span class="badge bg-success rounded-1">Aktif</span>
                                        <?php elseif ($r['status'] == 'Tidak Aktif') : ?>
                                            <span class="badge bg-secondary rounded-1">Nonaktif</span>
                                        <?php else : ?>
                                            <span class="badge bg-warning text-dark rounded-1"><?= esc($r['status']) ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($r['sk_spt']): ?>
                                            <a href="<?= base_url('uploads/spt/' . $r['sk_spt']) ?>" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-file"></i></a>
                                        <?php else: ?>
                                            <!-- buatkan tombol untuk upload memanggil modal -->
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#uploadModal" data-id="<?= $r['id'] ?>" data-type="spt"><i class="fa fa-upload"></i></button>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($r['sk_pks']): ?>
                                            <a href="<?= base_url('uploads/pks/' . $r['sk_pks']) ?>" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-file"></i></a>
                                        <?php else: ?>
                                            <!-- buatkan tombol untuk upload memanggil modal -->
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#uploadModal" data-id="<?= $r['id'] ?>" data-type="pks"><i class="fa fa-upload"></i></button>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php
                                        $encrypt = \Config\Services::encrypter();
                                        $id_riwayat_kerja_encrypted = bin2hex($encrypt->encrypt($r['id']));
                                        ?>
                                        <div class="d-flex gap-2">
                                            <!-- create detail button -->
                                            <div class="btn-group d-flex">
                                                <button type="button" class="btn btn-secondary btn-sm btn-gaji-uraian"
                                                    data-id="<?= $r['id'] ?>"
                                                    data-nama="<?= $r['nama'] ?>"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalInputGajiUraian">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                                <a href="<?= site_url('riwayat_kerja/detail/' . $id_riwayat_kerja_encrypted) ?>" class="btn btn-primary btn-sm">
                                                    <i class="fa fa-eye mt-1"></i>
                                                </a>
                                            </div>
                                            <!-- Example single danger button -->
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-danger dropdown-toggle rounded" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li class="dropdown-item">
                                                        <?php if (session()->get('level') == 'admin') : ?>
                                                            <button type="button" class="dropdown-item btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="<?= $r['id'] ?>" data-target="all">
                                                                <i class="fa fa-trash"></i> All
                                                            </button>
                                                        <?php endif; ?>
                                                    </li>
                                                    <li class="dropdown-item">
                                                        <!-- Hapus SPT -->
                                                        <button type="button" class="dropdown-item btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="<?= $r['id'] ?>" data-target="spt">
                                                            <i class="fa fa-trash"></i> SPT
                                                        </button>
                                                    </li>
                                                    <li class="dropdown-item">
                                                        <!-- Hapus PKS -->
                                                        <button type="button" class="dropdown-item btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="<?= $r['id'] ?>" data-target="pks">
                                                            <i class="fa fa-trash"></i> PKS
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
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
</div>

<!-- Modal Input Gaji dan Uraian Kerja -->
<div class="modal fade" id="modalInputGajiUraian" tabindex="-1" aria-labelledby="inputGajiUraianKerjaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="inputGajiUraianKerjaLabel">Input Gaji dan Uraian Kerja a.n <span id="nama_pegawai"></span> </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= site_url('riwayat_kerja/input_gaji_uraian') ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="id_riwayat" id="id_riwayat">
                    <div class="mb-3">
                        <label for="gaji" class="form-label">Gaji</label>
                        <input type="number" class="form-control" id="gaji" name="gaji" required placeholder="Masukkan Gaji Pegawai" min="0" step="any" value="">
                    </div>
                    <div class="mb-3">
                        <!-- buat note untuk memberikan delimiter ; setiap akhir kalimat -->
                        <label for="uraian_pekerjaan" class="form-label">Uraian Pekerjaan</label>
                        <small class="text-danger">Gunakan delimiter ; setiap akhir kalimat</small>
                        <textarea class="form-control" id="uraian_pekerjaan" name="uraian_pekerjaan" rows="3" required placeholder="Masukkan Uraian Pekerjaan" style="height: 90px; resize: vertical;"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Upload SPT -->
<!-- Jika Klik SPT Maka Header SPT -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel">Upload Dokumen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= site_url('riwayat_kerja/upload') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="id_riwayat" id="id_riwayat">
                    <input type="hidden" name="type" id="type">
                    <div class="mb-3">
                        <label for="fileUpload" class="form-label">Pilih File</label>
                        <input type="file" class="form-control" id="fileUpload" name="fileUpload" required accept=".pdf">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?= site_url('riwayat_kerja/hapus') ?>" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Hapus Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="delete-id">
                    <input type="hidden" name="target" id="delete-target">
                    <p id="delete-message">Apakah Anda yakin ingin menghapus data ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // Ubah judul modal saat tombol upload diklik
    const uploadModal = document.getElementById('uploadModal');
    uploadModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const type = button.getAttribute('data-type'); // "spt" atau "pks"
        const id = button.getAttribute('data-id');
        const modalTitle = uploadModal.querySelector('.modal-title');
        const inputId = uploadModal.querySelector('#id_riwayat');
        const inputType = uploadModal.querySelector('#type');

        // Set judul sesuai tipe
        if (type === 'spt') {
            modalTitle.textContent = 'Upload SPT';
        } else if (type === 'pks') {
            modalTitle.textContent = 'Upload PKS';
        } else {
            modalTitle.textContent = 'Upload Dokumen';
        }

        // Set nilai tersembunyi
        inputId.value = id;
        inputType.value = type;
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const target = button.getAttribute('data-target'); // all | spt | pks

            const inputId = deleteModal.querySelector('#delete-id');
            const inputTarget = deleteModal.querySelector('#delete-target');
            const message = deleteModal.querySelector('#delete-message');
            const title = deleteModal.querySelector('.modal-title');

            inputId.value = id;
            inputTarget.value = target;

            if (target === 'spt') {
                title.textContent = 'Hapus SPT';
                message.textContent = 'Apakah Anda yakin ingin menghapus file SPT ini?';
            } else if (target === 'pks') {
                title.textContent = 'Hapus PKS';
                message.textContent = 'Apakah Anda yakin ingin menghapus file PKS ini?';
            } else {
                title.textContent = 'Hapus Data';
                message.textContent = 'Apakah Anda yakin ingin menghapus seluruh data riwayat pekerjaan ini?';
            }
        });
    });
</script>

<script>
    $(document).on('click', '.btn-gaji-uraian', function() {
        const id = $(this).data('id');
        $('#id_riwayat').val(id);
        const nama = $(this).data('nama');
        $('#nama_pegawai').text(nama);
        // set value gaji dan uraian pekerjaan jika sudah ada
        $.ajax({
            url: '<?= site_url('riwayat_kerja/getGajiUraian') ?>',
            type: 'POST',
            data: {
                id_riwayat: id
            },
            dataType: 'json',
            success: function(response) {
                if (response) {
                    $('#gaji').val(response.gaji);
                    $('#uraian_pekerjaan').val(response.uraian_pekerjaan);
                } else {
                    $('#gaji').val('');
                    $('#uraian_pekerjaan').val('');
                }
            },
            error: function() {
                alert('Error fetching data');
            }
        });
    });
</script>

<?= $this->endSection() ?>