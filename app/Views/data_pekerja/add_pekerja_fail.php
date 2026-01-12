<?= $this->extend('dashboard/main') ?>
<?= $this->section('content') ?>

<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Form Tambah Data Tenaga Kerja</h4>
            <p class="card-description"> Tolong Inputkan Semua Data Dengan Benar!!! </p>
            <form class="forms-sample" method="POST" action="<?= site_url('data_pekerja/store') ?>">
                <div class="form-group">
                    <label for="input_nik">NIK</label>
                    <input type="text" class="form-control" id="input_nik" placeholder="Masukan NIK" name="nik">
                </div>
                <div class="form-group">
                    <label for="input_Nama">Nama Lengkap</label>
                    <input type="text" class="form-control" id="input_Nama" placeholder="Masukan Nama" name="nama">
                </div>
                <div class="form-group">
                    <label for="input_Tempat_Lahir">Tempat Lahir</label>
                    <input type="text" class="form-control" id="input_Tempat_Lahir" placeholder="Masukan Tempat Lahir" name="tempat_lahir">
                </div>
                <div class="form-group">
                    <label for="input_Tanggal_Lahir">Tanggal Lahir</label>
                    <input type="date" class="form-control" id="input_Tanggal_Lahir" placeholder="Masukan Tanggal Lahir" name="tanggal_lahir">
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
                    <input type="text" class="form-control" id="input_Jurusan" placeholder="Masukan Jurusan" name="jurusan">
                </div>
                <div class="form-group">
                    <label for="input_Gelar_D">Gelar Depan</label>
                    <input type="text" class="form-control" id="input_Gelar_D" placeholder="Masukan Gelar Depan" name="gelar_depan">
                </div>
                <div class="form-group">
                    <label for="input_Gelar_B">Gelar Belakang</label>
                    <input type="text" class="form-control" id="input_Gelar_B" placeholder="Masukan Gelar Belakang" name="gelar_belakang">
                </div>
                <button type=" submit" class="btn btn-primary me-2">Simpan</button>
                <a href="<?= site_url('data_pekerja') ?>" class="btn btn-light">Batal</a>
            </form>
        </div>
    </div>
</div>



<?= $this->endSection() ?>