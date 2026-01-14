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

            <h4 class="card-title">Form Edit Data <?= $subtitle ?></h4>
            <p class="card-description"> Tolong Inputkan Semua Data Dengan Benar!!! </p>

            <form class="forms-sample"
                method="POST"
                action="<?= site_url('riwayat_kerja/update/' . $id_riwayat_encrypted) ?>"
                enctype="multipart/form-data">

                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">

                <div id="form-step-1" class="form-step">
                    <h4 class="card-title">Data Pekerjaan <?= $pekerja['nama'] ?></h4>

                    <!-- pekerjaan -->
                    <div class="form-group">
                        <label for="input_pekerjaan">Pekerjaan</label>
                        <select class="form-control" id="input_pekerjaan" name="pekerjaan" required>
                            <option value="" disabled>-- Pilih Pekerjaan --</option>
                            <?php foreach ($pekerjaan as $row) : ?>
                                <option value="<?= esc($row['id_nama_pekerjaan']) ?>"
                                    <?= old('pekerjaan', $riwayat['id_nama_pekerjaan']) == $row['id_nama_pekerjaan'] ? 'selected' : '' ?>>
                                    <?= esc($row['pekerjaan']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- jenis pegawai -->
                    <div class="form-group">
                        <label for="input_jenis_pegawai">Jenis Pegawai</label>
                        <select class="form-control" id="input_jenis_pegawai" name="jenis_pegawai">
                            <option value="" disabled>Pilih Jenis Pegawai</option>
                            <option value="Kontrak Dinas"
                                <?= old('jenis_pegawai', $riwayat['jenis_pegawai']) == 'Kontrak Dinas' ? 'selected' : '' ?>>
                                Kontrak Dinas
                            </option>
                            <option value="Kontrak Walikota"
                                <?= old('jenis_pegawai', $riwayat['jenis_pegawai']) == 'Kontrak Walikota' ? 'selected' : '' ?>>
                                Kontrak Walikota
                            </option>
                        </select>
                    </div>

                    <!-- unit kerja -->
                    <div class="form-group">
                        <label for="input_unit_kerja">Unit Kerja</label>
                        <select class="form-control" id="input_unit_kerja" name="unit_kerja" required>
                            <option value="" disabled>-- Pilih Unit Kerja --</option>
                            <?php foreach ($unit_kerja as $row) : ?>
                                <?php if (session()->get('unitKerja') == 'Dinas Lingkungan Hidup'): ?>
                                    <?php if ($row['unit_kerja'] != 'Dinas Lingkungan Hidup') : ?>
                                        <option value="<?= esc($row['id_unit_kerja']) ?>"
                                            <?= old('unit_kerja', $riwayat['id_unit_kerja']) == $row['id_unit_kerja'] ? 'selected' : '' ?>>
                                            <?= esc($row['unit_kerja']) ?>
                                        </option>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <?php if (session()->get('id_unit_kerja') == $row['id_unit_kerja']) : ?>
                                        <option value="<?= esc($row['id_unit_kerja']) ?>" selected>
                                            <?= esc($row['unit_kerja']) ?>
                                        </option>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- gaji -->
                    <div class="form-group">
                        <label for="input_gaji">Gaji</label>
                        <input type="number" class="form-control" id="input_gaji" name="gaji"
                            value="<?= old('gaji', $riwayat['gaji']) ?>" required>
                    </div>

                    <!-- uraian kerja -->
                    <div class="form-group">
                        <label for="input_uraian_kerja">Uraian Kerja</label>
                        <textarea class="form-control" id="input_uraian_kerja"
                            name="uraian_pekerjaan"
                            rows="3"
                            style="resize: vertical; height: 90px;"
                            required><?= old('uraian_pekerjaan', $riwayat['uraian_pekerjaan']) ?></textarea>
                    </div>

                    <!-- tahun -->
                    <div class="form-group">
                        <label for="input_tahun">Tahun</label>
                        <input type="number" class="form-control" id="input_tahun" name="tahun"
                            value="<?= old('tahun', $riwayat['tahun']) ?>" max="<?= date('Y') ?>" required>
                    </div>

                    <!-- tmt -->
                    <div class="form-group">
                        <label for="input_tmt">TMT Kerja</label>
                        <input type="date" class="form-control" id="input_tmt" name="tmt_kerja"
                            value="<?= old('tmt_kerja', $riwayat['tmt_kerja']) ?>" required>
                    </div>

                    <!-- tst -->
                    <div class="form-group">
                        <label for="input_tst">TST Kerja</label>
                        <input type="date" class="form-control" id="input_tst" name="tst_kerja"
                            value="<?= old('tst_kerja', $riwayat['tst_kerja']) ?>" required>
                    </div>

                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="<?= site_url('riwayat_kerja/riwayat/' . $id_pekerja_encrypted) ?>" class="btn btn-dark">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>