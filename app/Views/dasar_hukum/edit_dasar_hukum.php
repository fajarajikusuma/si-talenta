<?= $this->extend('dashboard/main') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <!-- alert -->
                <?php if (session()->getFlashdata('error')) : ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <!-- end alert -->
                <h4 class="card-title fw-bold">Edit Data <?= $title ?></h4>

                <form action="<?= site_url('dasar_hukum/update/' . $id_encrypted) ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="nama_dasar_hukum" class="form-label">Nama Dasar Hukum</label>
                        <input type="text" class="form-control" id="nama_dasar_hukum" name="nama_dasar_hukum" value="<?= esc($dasar_hukum['nama_dasar_hukum']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="nomor" class="form-label">Nomor</label>
                        <input type="text" class="form-control" id="nomor" name="nomor" value="<?= esc($dasar_hukum['nomor']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="tahun" class="form-label">Tahun</label>
                        <input type="number" class="form-control" id="tahun" name="tahun" value="<?= esc($dasar_hukum['tahun']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="tentang" class="form-label">Tentang</label>
                        <textarea class="form-control" id="tentang" name="tentang" rows="3" required><?= esc($dasar_hukum['tentang']) ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="upload_dokumen" class="form-label">Dokumen (PDF, opsional)</label><br>
                        <?php if (!empty($dasar_hukum['upload_dokumen'])) : ?>
                            <a href="<?= base_url('uploads/dasar_hukum/' . $dasar_hukum['upload_dokumen']) ?>" target="_blank" class="btn btn-sm btn-info mb-2">Lihat Dokumen Lama</a>
                        <?php endif; ?>
                        <input type="file" class="form-control" id="upload_dokumen" name="upload_dokumen" accept="application/pdf">
                        <small class="text-muted">Kosongkan jika tidak ingin mengubah dokumen.</small>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="Tidak Aktif" <?= $dasar_hukum['status'] === 'Tidak Aktif' ? 'selected' : '' ?>>Tidak Aktif</option>
                            <option value="Aktif 1" <?= $dasar_hukum['status'] === 'Aktif 1' ? 'selected' : '' ?>>Aktif 1</option>
                            <option value="Aktif 2" <?= $dasar_hukum['status'] === 'Aktif 2' ? 'selected' : '' ?>>Aktif 2</option>
                        </select>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
                        <a href="<?= site_url('dasar_hukum') ?>" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Batal</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>