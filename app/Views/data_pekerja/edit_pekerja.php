<?= $this->extend('dashboard/main') ?>
<?= $this->section('content') ?>
<style>
    .form-step {
        transition: all 0.3s ease-in-out;
    }

    .d-none {
        display: none;
    }
</style>

<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <h4 class="card-title">Form Edit Data <?= $subtitle ?></h4>
            <p class="card-description"> Edit Data dengan Teliti! </p>

            <form class="forms-sample" method="POST" action="<?= site_url('data_pekerja/update/' . $id_pekerja_decrypt) ?>" enctype="multipart/form-data">
                <div id="form-step-1" class="form-step">
                    <h4 class="card-title">Data Pribadi</h4>
                    <div class="form-group">
                        <label for="input_nik">NIK</label>
                        <input type="text" class="form-control" id="input_nik" name="nik" value="<?= esc($pekerja['nik']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="input_Nama">Nama Lengkap</label>
                        <input type="text" class="form-control" id="input_Nama" name="nama" value="<?= esc($pekerja['nama']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="input_Tempat_Lahir">Tempat Lahir</label>
                        <input type="text" class="form-control" id="input_Tempat_Lahir" name="tempat_lahir" value="<?= esc($pekerja['tempat_lahir']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="input_Tanggal_Lahir">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="input_Tanggal_Lahir" name="tanggal_lahir" value="<?= esc($pekerja['tanggal_lahir']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="input_Jenis_Kelamin">Jenis Kelamin</label>
                        <select class="form-control" id="input_Jenis_Kelamin" name="jenis_kelamin">
                            <option disabled>Pilih Jenis Kelamin</option>
                            <option value="L" <?= $pekerja['jenis_kelamin'] === 'L' ? 'selected' : '' ?>>Laki-laki</option>
                            <option value="P" <?= $pekerja['jenis_kelamin'] === 'P' ? 'selected' : '' ?>>Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="input_Alamat">Alamat</label>
                        <textarea class="form-control" id="input_Alamat" name="alamat"><?= esc($pekerja['alamat']) ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="input_rt_rw">RT / RW</label>
                        <input type="text" class="form-control" id="input_rt_rw" name="rt_rw" value="<?= esc($pekerja['rt/rw']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="input_desa">Desa / Kelurahan</label>
                        <input type="text" class="form-control" id="input_desa" name="desa_kelurahan" value="<?= esc($pekerja['desa/kelurahan']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="input_kecamatan">Kecamatan</label>
                        <input type="text" class="form-control" id="input_kecamatan" name="kecamatan" value="<?= esc($pekerja['kecamatan']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="input_kota">Kota Tinggal</label>
                        <input type="text" class="form-control" id="input_kota" name="kota" value="<?= esc($pekerja['kota_tinggal']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="input_provinsi">Provinsi</label>
                        <input type="text" class="form-control" id="input_provinsi" name="provinsi" value="<?= esc($pekerja['provinsi']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="input_kode_pos">Kode Pos</label>
                        <input type="text" class="form-control" id="input_kode_pos" name="kode_pos" value="<?= esc($pekerja['kode_pos']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="input_ktp">Upload KTP</label>
                        <input type="file" class="form-control" id="input_ktp" name="ktp" accept=".jpg,.jpeg,.png,.pdf">
                        <input type="text" class="form-control" id="input_ktp_lama" name="ktp_lama" value="<?= esc($pekerja['ktp']) ?>" hidden>
                        <small class="form-text text-muted">File JPG, PNG, atau PDF. Maksimal 2MB.</small>
                        <!-- Tampilkan link download/preview jika ada file lama -->
                        <?php if (!empty($pekerja['ktp'])): ?>
                            <p class="mt-2">
                                KTP lama:
                                <a href="<?= base_url('assets/ktp/' . $pekerja['ktp']) ?>" target="_blank">
                                    <?= esc($pekerja['ktp']) ?>
                                </a>
                            </p>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="input_Pendidikan">Pendidikan</label>
                        <select class="form-control" id="input_Pendidikan" name="pendidikan">
                            <?php
                            $pendidikanOptions = ['SD', 'SMP', 'SMA', 'SMK', 'D3', 'S1', 'S2', 'S3'];
                            foreach ($pendidikanOptions as $option) :
                            ?>
                                <option value="<?= $option ?>" <?= $pekerja['pendidikan'] === $option ? 'selected' : '' ?>><?= $option ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="input_Jurusan">Jurusan</label>
                        <input type="text" class="form-control" id="input_Jurusan" name="jurusan" value="<?= esc($pekerja['jurusan']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="input_Gelar_D">Gelar Depan</label>
                        <input type="text" class="form-control" id="input_Gelar_D" name="gelar_depan" value="<?= esc($pekerja['gelar_depan']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="input_Gelar_B">Gelar Belakang</label>
                        <input type="text" class="form-control" id="input_Gelar_B" name="gelar_belakang" value="<?= esc($pekerja['gelar_belakang']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="input_ijasah">Upload Ijasah</label>
                        <input type="file" class="form-control" id="input_ijasah" name="ijasah" accept=".jpg,.jpeg,.png,.pdf">
                        <input type="text" class="form-control" id="input_ijasah_lama" name="ijasah_lama" value="<?= esc($pekerja['ijasah']) ?>" hidden>
                        <small class="form-text text-muted">File JPG, PNG, atau PDF. Maksimal 2MB.</small>
                        <?php if (!empty($pekerja['ijasah'])): ?>
                            <p class="mt-2">
                                Ijazah lama:
                                <a href="<?= base_url('assets/ijasah/' . $pekerja['ijasah']) ?>" target="_blank">
                                    <?= esc($pekerja['ijasah']) ?>
                                </a>
                            </p>
                        <?php endif; ?>
                    </div>

                    <?php if (session()->get('page') == 'new'): ?>
                        <button type="button" class="btn btn-primary" onclick="nextStep()">Selanjutnya</button>
                        <a href="<?= site_url('data_pekerja') . '/' . session()->get('page') ?>" class="btn btn-dark">Batal</a>
                    <?php endif; ?>
                </div>
                <?php if (session()->get('page') == 'new'): ?>
                    <div id="form-step-2" class="form-step d-none">
                        <h4 class="card-title">Data Pekerjaan</h4>

                        <div class="form-group">
                            <label for="input_pekerjaan">Pekerjaan</label>
                            <select class="form-control" id="input_pekerjaan" name="pekerjaan" required>
                                <option disabled>-- Pilih Pekerjaan --</option>
                                <?php foreach ($pekerjaan as $row) : ?>
                                    <option value="<?= $row['id_nama_pekerjaan'] ?>" <?= $row['id_nama_pekerjaan'] == $pekerja['id_nama_pekerjaan'] ? 'selected' : '' ?>>
                                        <?= esc($row['pekerjaan']) ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="input_jenis_pegawai">Jenis Pegawai</label>
                            <select class="form-control" id="input_jenis_pegawai" name="jenis_pegawai">
                                <option value="Kontrak Dinas" <?= $pekerja['jenis_pegawai'] === 'Kontrak Dinas' ? 'selected' : '' ?>>Kontrak Dinas</option>
                                <option value="Kontrak Walikota" <?= $pekerja['jenis_pegawai'] === 'Kontrak Walikota' ? 'selected' : '' ?>>Kontrak Walikota</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="input_unit_kerja">Unit Kerja</label>
                            <select class="form-control" id="input_unit_kerja" name="unit_kerja" required>
                                <option disabled>-- Pilih Unit Kerja --</option>
                                <?php foreach ($unit_kerja as $row) : ?>
                                    <?php if ($row['unit_kerja'] != 'Dinas Lingkungan Hidup') : ?>
                                        <option value="<?= $row['id_unit_kerja'] ?>" <?= $row['id_unit_kerja'] == $pekerja['id_unit_kerja'] ? 'selected' : '' ?>>
                                            <?= esc($row['unit_kerja']) ?>
                                        </option>
                                    <?php endif; ?>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="input_tahun">Tahun</label>
                            <input type="number" class="form-control" id="input_tahun" name="tahun" value="<?= esc($pekerja['tahun']) ?>">
                        </div>

                        <div class="form-group">
                            <label for="input_tmt">TMT Kerja</label>
                            <input type="date" class="form-control" id="input_tmt" name="tmt_kerja" value="<?= esc($pekerja['tmt_kerja']) ?>">
                        </div>

                        <div class="form-group">
                            <label for="input_tst">TST Kerja</label>
                            <input type="date" class="form-control" id="input_tst" name="tst_kerja" value="<?= esc($pekerja['tst_kerja']) ?>">
                        </div>
                    <?php endif; ?>
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <?php if (session()->get('page') != 'new'): ?>
                        <a href="<?= site_url('data_pekerja') . '/' . session()->get('page') ?>" class="btn btn-dark">Batal</a>
                    <?php endif; ?>
                    <?php if (session()->get('page') == 'new'): ?>
                        <button type="button" class="btn btn-secondary" onclick="prevStep()">Kembali</button>
                    <?php endif; ?>
                    <?php if (session()->get('page') == 'new'): ?>
                    </div>
                <?php endif; ?>
            </form>

            <script>
                function nextStep() {
                    document.getElementById('form-step-1').classList.add('d-none');
                    document.getElementById('form-step-2').classList.remove('d-none');
                }

                function prevStep() {
                    document.getElementById('form-step-2').classList.add('d-none');
                    document.getElementById('form-step-1').classList.remove('d-none');
                }
            </script>
        </div>
    </div>
</div>

<?= $this->endSection() ?>