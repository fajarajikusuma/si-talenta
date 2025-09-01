<?= $this->extend('dashboard/main') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h4 class="card-title m-0 fw-bold"><?= 'Data ' . $title ?></h4>
                <a href="<?= site_url('dasar_hukum/add') ?>" class="btn btn-primary"><i class="fa fa-plus-square"></i></a>
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
                <div id="statusMessage" class="alert alert-success alert-dismissible fade show d-none" role="alert">
                    <span id="statusText">Status berhasil diubah.</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover" id="tableDataPekerja">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th class="text-start">Nama Dasar Hukum</th>
                                <th>Nomor</th>
                                <th>Tahun</th>
                                <th>Tentang</th>
                                <th>Dokumen</th>
                                <th class="text-center">Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($dasar_hukum as $row) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td class="text-start"><?= $row['nama_dasar_hukum'] ?></td>
                                    <td><?= $row['nomor'] ?></td>
                                    <td><?= $row['tahun'] ?></td>
                                    <td><?= $row['tentang'] ?></td>
                                    <td>
                                        <a href="<?= base_url('uploads/dasar_hukum/' . $row['upload_dokumen']) ?>" target="_blank" class="btn btn-sm btn-info">Lihat</a>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($row['status'] == 'Aktif 1') : ?>
                                            <span class="badge bg-success btn-status rounded-1" data-id="<?= $row['id_dasar_hukum_encrypted'] ?>" data-status="Aktif 1" style="cursor: pointer;">Aktif 1</span>
                                        <?php elseif ($row['status'] == 'Aktif 2') : ?>
                                            <span class="badge bg-warning btn-status rounded-1" data-id="<?= $row['id_dasar_hukum_encrypted'] ?>" data-status="Aktif 2" style="cursor: pointer;">Aktif 2</span>
                                        <?php else : ?>
                                            <span class="badge bg-danger btn-status rounded-1" data-id="<?= $row['id_dasar_hukum_encrypted'] ?>" data-status="Tidak Aktif" style="cursor: pointer;">Tidak Aktif</span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <div class="d-flex btn-group">
                                            <a href="<?= site_url('dasar_hukum/edit/' . $row['id_dasar_hukum_encrypted']) ?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                                            <a href="<?= site_url('dasar_hukum/delete/' . $row['id_dasar_hukum_encrypted']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data <?= $row['nama_dasar_hukum'] . ' Nomor ' . $row['nomor'] . ' Tahun ' . $row['tahun'] . ' Tentang ' . $row['tentang'] ?> ?')"><i class="fa fa-trash"></i></a>
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

<script>
    $(document).ready(function() {
        $('.btn-status').on('click', function() {
            const id = $(this).data('id');
            const currentStatus = $(this).data('status');

            // Status berputar: Tidak Aktif → Aktif 1 → Aktif 2 → Tidak Aktif ...
            const statusList = ['Tidak Aktif', 'Aktif 1', 'Aktif 2'];
            const currentIndex = statusList.indexOf(currentStatus);
            const nextIndex = (currentIndex + 1) % statusList.length;
            const newStatus = statusList[nextIndex];

            $.ajax({
                url: "<?= site_url('dasar_hukum/change_status') ?>",
                method: "POST",
                data: {
                    id: id,
                    status: newStatus
                },
                success: function(response) {
                    if (response.success) {
                        const badge = $('span[data-id="' + id + '"]');
                        badge.text(newStatus);
                        badge
                            .removeClass('bg-success bg-danger bg-warning')
                            .addClass(
                                newStatus === 'Aktif 1' ? 'bg-success' :
                                newStatus === 'Aktif 2' ? 'bg-warning' :
                                'bg-danger'
                            )
                            .data('status', newStatus);

                        $('#statusText').text('Status berhasil diubah menjadi "' + newStatus + '".');
                        $('#statusMessage').removeClass('d-none').fadeIn();

                        setTimeout(() => {
                            $('#statusMessage').fadeOut(() => {
                                $('#statusMessage').addClass('d-none');
                            });
                        }, 3000);
                    } else {
                        alert('Gagal mengubah status.');
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan saat mengubah status.');
                }
            });
        });
    });
</script>


<?= $this->endSection() ?>