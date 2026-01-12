<?= $this->extend('dashboard/main') ?>
<?= $this->section('content') ?>

<div class="col-12 grid-margin stretch-card">
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
            <h4 class="card-title">Form Tambah Data <?= $subtitle ?></h4>
            <p class="card-description"> Tolong Inputkan Semua Data Dengan Benar!!! </p>
            <form class="forms-sample" method="POST" action="<?= site_url('riwayat_kerja/store' . '/' . $id_pekerja_encrypted) ?>" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div id="form-step-1" class="form-step">
                    <h4 class="card-title">Data Pekerjaan <?= $pekerja['nama'] ?></h4>
                    <div class="form-group">
                        <label for="input_pekerjaan">Pekerjaan</label>
                        <select class="form-control" id="input_pekerjaan" name="pekerjaan" required>
                            <option value="" disabled selected>-- Pilih Pekerjaan --</option>
                            <?php foreach ($pekerjaan as $row) : ?>
                                <option value="<?= esc($row['id_nama_pekerjaan']) ?>"><?= esc($row['pekerjaan']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="input_jenis_pegawai">Jenis Pegawai</label>
                        <select class="form-control" id="input_jenis_pegawai" name="jenis_pegawai">
                            <option value="" disabled selected>Pilih Jenis Pegawai</option>
                            <option value="Kontrak Dinas">Kontrak Dinas</option>
                            <option value="Kontrak Walikota">Kontrak Walikota</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="input_unit_kerja">Unit Kerja</label>
                        <select class="form-control" id="input_unit_kerja" name="unit_kerja" required>
                            <option value="" disabled selected>-- Pilih Unit Kerja --</option>
                            <?php foreach ($unit_kerja as $row) : ?>
                                <?php if (session()->get('unitKerja') == 'Dinas Lingkungan Hidup'): ?>
                                    <?php if ($row['unit_kerja'] != 'Dinas Lingkungan Hidup') : ?>
                                        <option value="<?= esc($row['id_unit_kerja']) ?>"><?= esc($row['unit_kerja']) ?></option>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <?php if (session()->get('id_unit_kerja') == $row['id_unit_kerja']) : ?>
                                        <option value="<?= esc($row['id_unit_kerja']) ?>"><?= esc($row['unit_kerja']) ?></option>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- inputan gaji -->
                    <div class="form-group">
                        <label for="input_gaji">Gaji</label>
                        <input type="number" class="form-control" id="input_gaji" name="gaji" placeholder="Masukkan Gaji" value="<?= old('gaji') ?>" required>
                    </div>

                    <!-- inputan uraian kerja -->
                    <div class="form-group">
                        <label for="input_uraian_kerja">Uraian Kerja</label>
                        <textarea class="form-control" id="input_uraian_kerja" name="uraian_pekerjaan" rows="3" style="resize: vertical; height: 90px;" placeholder="Masukkan Uraian Kerja" required><?= old('uraian_kerja') ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="input_tahun">Tahun</label>
                        <input type="number" class="form-control" id="input_tahun" name="tahun" placeholder="Masukkan Tahun" value="<?= date('Y') ?>" max="<?= date('Y') ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="input_tmt">TMT Kerja</label>
                        <input type="date" class="form-control" id="input_tmt" name="tmt_kerja" value="<?= date('Y-m-d') ?>" max="<?= date('Y-m-d') ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="input_tst">TST Kerja</label>
                        <input type="date" class="form-control" id="input_tst" name="tst_kerja" value="<?= date('Y') . '-12-31' ?>" max="<?= date('Y') . '-12-31' ?>" required>
                    </div>

                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="<?= site_url('riwayat_kerja/riwayat/' . $id_pekerja_encrypted) ?>" class="btn btn-dark">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>



<?= $this->endSection() ?>