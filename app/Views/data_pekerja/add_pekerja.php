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
            <form class="forms-sample" method="POST" action="<?= site_url('data_pekerja/store') ?>" enctype="multipart/form-data">
                <div id="form-step-1" class="form-step">
                    <h4 class="card-title">Data Pribadi</h4>
                    <!-- Isi form Step 1 seperti NIK, Nama, dll -->
                    <div class="form-group">
                        <label for="input_nik">NIK</label>
                        <input type="text" class="form-control" id="input_nik" placeholder="Masukan NIK" name="nik" value="<?= old('nik') ?>">
                    </div>
                    <div class="form-group">
                        <label for="input_Nama">Nama Lengkap</label>
                        <input type="text" class="form-control" id="input_Nama" placeholder="Masukan Nama" name="nama" value="<?= old('nama') ?>">
                    </div>
                    <div class="form-group">
                        <label for="input_Tempat_Lahir">Tempat Lahir</label>
                        <input type="text" class="form-control" id="input_Tempat_Lahir" placeholder="Masukan Tempat Lahir" name="tempat_lahir" value="<?= old('tempat_lahir') ?>">
                    </div>
                    <div class="form-group">
                        <label for="input_Tanggal_Lahir">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="input_Tanggal_Lahir" placeholder="Masukan Tanggal Lahir" name="tanggal_lahir" value="<?= old('tanggal_lahir') ?>">
                    </div>
                    <div class="form-group">
                        <label for="input_Jenis_Kelamin">Jenis Kelamin</label>
                        <select class="form-control" id="input_Jenis_Kelamin" name="jenis_kelamin">
                            <option value="" disabled selected>Pilih Jenis Kelamin</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <!-- alamat -->
                    <div class="form-group">
                        <label for="input_Alamat">Alamat</label>
                        <textarea class="form-control" id="input_Alamat" placeholder="Masukan Alamat" name="alamat"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="input_rt_rw">RT / RW</label>
                        <input type="text" class="form-control" id="input_rt_rw" placeholder="Contoh: 04/02" name="rt_rw" value="<?= old('rt_rw') ?>">
                    </div>
                    <div class="form-group">
                        <label for="input_desa">Desa / Kelurahan</label>
                        <input type="text" class="form-control" id="input_desa" placeholder="Masukkan Desa atau Kelurahan" name="desa_kelurahan" value="<?= old('desa_kelurahan') ?>">
                    </div>
                    <div class="form-group">
                        <label for="input_kecamatan">Kecamatan</label>
                        <input type="text" class="form-control" id="input_kecamatan" placeholder="Masukkan Kecamatan" name="kecamatan" value="<?= old('kecamatan') ?>">
                    </div>
                    <div class="form-group">
                        <label for="input_kota">Kota Tinggal</label>
                        <input type="text" class="form-control" id="input_kota" placeholder="Masukkan Kota Tinggal" name="kota" value="<?= old('kota') ?>">
                    </div>
                    <div class="form-group">
                        <label for="input_provinsi">Provinsi</label>
                        <input type="text" class="form-control" id="input_provinsi" placeholder="Masukkan Provinsi" name="provinsi" value="<?= old('provinsi') ?>">
                    </div>
                    <div class="form-group">
                        <label for="input_kode_pos">Kode Pos</label>
                        <input type="text" class="form-control" id="input_kode_pos" placeholder="Masukkan Kode Pos" name="kode_pos" value="<?= old('kode_pos') ?>">
                    </div>
                    <div class="form-group">
                        <label for="input_ktp">Upload KTP</label>
                        <input type="file" class="form-control" id="input_ktp" name="ktp" accept=".jpg,.jpeg,.png,.pdf" value="<?= old('upload_ktp') ?>">
                        <small class="form-text text-muted">File berupa JPG, PNG, atau PDF. Maksimal 2MB.</small>
                    </div>
                    <div class="form-group">
                        <label for="input_Pendidikan">Pendidikan</label>
                        <select class="form-control" id="input_Pendidikan" name="pendidikan">
                            <option value="" disabled selected>Pilih Pendidikan</option>
                            <option value="SD">SD</option>
                            <option value="SMP">SMP</option>
                            <option value="SMA">SMA</option>
                            <option value="SMK">SMK</option>
                            <option value="D3">D3</option>
                            <option value="S1">S1</option>
                            <option value="S2">S2</option>
                            <option value="S3">S3</option>
                        </select>
                    </div>
                    <!-- jurusan -->
                    <div class="form-group">
                        <label for="input_Jurusan">Jurusan</label>
                        <input type="text" class="form-control" id="input_Jurusan" placeholder="Masukan Jurusan" name="jurusan" value="<?= old('jurusan') ?>">
                    </div>
                    <div class="form-group">
                        <label for="input_Gelar_D">Gelar Depan</label>
                        <input type="text" class="form-control" id="input_Gelar_D" placeholder="Masukan Gelar Depan" name="gelar_depan" value="<?= old('gelar_depan') ?>">
                    </div>
                    <div class="form-group">
                        <label for="input_Gelar_B">Gelar Belakang</label>
                        <input type="text" class="form-control" id="input_Gelar_B" placeholder="Masukan Gelar Belakang" name="gelar_belakang" value="<?= old('gelar_belakang') ?>">
                    </div>
                    <div class="form-group">
                        <label for="input_ijasah">Upload Ijasah</label>
                        <input type="file" class="form-control" id="input_ijasah" name="ijasah" accept=".jpg,.jpeg,.png,.pdf" value="<?= old('upload_ijasah') ?>">
                        <small class="form-text text-muted">File berupa JPG, PNG, atau PDF. Maksimal 2MB.</small>
                    </div>
                    <!-- ... (lanjutkan isi sesuai form sebelumnya) -->
                    <button type="button" class="btn btn-primary" onclick="nextStep()">Selanjutnya</button>
                    <a href="<?= site_url('data_pekerja/new') ?>" class="btn btn-dark">Batal</a>
                </div>

                <div id="form-step-2" class="form-step d-none">
                    <h4 class="card-title">Data Pekerjaan</h4>
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
                                <?php if ($row['unit_kerja'] != 'Dinas Lingkungan Hidup') : ?>
                                    <option value="<?= esc($row['id_unit_kerja']) ?>"><?= esc($row['unit_kerja']) ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="input_tahun">Tahun</label>
                        <input type="number" class="form-control" id="input_tahun" name="tahun" placeholder="Masukkan Tahun" value="<?= date('Y') ?>">
                    </div>

                    <div class="form-group">
                        <label for="input_tmt">TMT Kerja</label>
                        <input type="date" class="form-control" id="input_tmt" name="tmt_kerja" value="<?= date('Y-m-d') ?>">
                    </div>

                    <div class="form-group">
                        <label for="input_tst">TST Kerja</label>
                        <input type="date" class="form-control" id="input_tst" name="tst_kerja" value="<?= date('Y') . '-12-31' ?>">
                    </div>

                    <button type="submit" class="btn btn-success">Simpan</button>
                    <button type="button" class="btn btn-secondary" onclick="prevStep()">Kembali</button>
                </div>
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