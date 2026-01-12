<?= $this->extend('dashboard/main') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h4 class="card-title m-0 fw-bold"><?= 'Data ' . $subtitle ?></h4>
                <a href="<?= site_url('daftar_kepala/add') ?>" class="btn btn-primary"><i class="fa fa-plus-square"></i></a>
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
                                <th class="text-start">NIP</th>
                                <th>Nama Kepala</th>
                                <th>Unit Kerja</th>
                                <th class="text-center">Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($daftar_kepala as $row) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td class="text-start"><?= $row['nip'] ?></td>
                                    <td><?= $row['nama_kepala'] ?></td>
                                    <td><?= $row['unit_kerja'] ?></td>
                                    <td class="text-center">
                                        <?php if ($row['status'] == 'Aktif') : ?>
                                            <span class="badge bg-success btn-status rounded-1" data-id="<?= $row['id_kepala_encrypted'] ?>" data-status="Aktif" style="cursor: pointer;">Aktif</span>
                                        <?php else : ?>
                                            <span class="badge bg-danger btn-status rounded-1" data-id="<?= $row['id_kepala_encrypted'] ?>" data-status="Tidak Aktif" style="cursor: pointer;">Tidak Aktif</span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <div class="d-flex btn-group">
                                            <a href="<?= site_url('daftar_kepala/detail/' . $row['id_kepala_encrypted']) ?>" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></a>
                                            <a href="<?= site_url('daftar_kepala/edit/' . $row['id_kepala_encrypted']) ?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                                            <a href="<?= site_url('daftar_kepala/delete/' . $row['id_kepala_encrypted']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data <?= $row['nama_kepala'] ?> ?')"><i class="fa fa-trash"></i></a>
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
            const newStatus = currentStatus === 'Aktif' ? 'Tidak Aktif' : 'Aktif';

            $.ajax({
                url: "<?= site_url('daftar_kepala/change_status') ?>",
                method: "POST",
                data: {
                    id: id,
                    status: newStatus
                },
                // success: function(response) {
                //     if (response.success) {
                //         console.log(id, newStatus);
                //         // Update tampilan status di tabel tanpa reload
                //         const badge = $('span[data-id="' + id + '"]');
                //         badge.text(newStatus);
                //         badge
                //             .removeClass('bg-success bg-danger')
                //             .addClass(newStatus === 'Aktif' ? 'bg-success' : 'bg-danger')
                //             .data('status', newStatus);
                //     } else {
                //         alert('Gagal mengubah status.');
                //     }
                // },
                success: function(response) {
                    if (response.success) {
                        const badge = $('span[data-id="' + id + '"]');
                        badge.text(newStatus);
                        badge
                            .removeClass('bg-success bg-danger')
                            .addClass(newStatus === 'Aktif' ? 'bg-success' : 'bg-danger')
                            .data('status', newStatus);

                        // Tampilkan pesan sukses
                        $('#statusText').text('Status berhasil diubah menjadi "' + newStatus + '".');
                        $('#statusMessage').removeClass('d-none').fadeIn();

                        // Sembunyikan otomatis setelah 3 detik
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