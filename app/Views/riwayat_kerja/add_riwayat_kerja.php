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
                        <label for="input_status_pegawai">Status Pegawai <span class="text-danger">*</span></label>
                        <select class="form-control" id="input_status_pegawai" name="status_pegawai" required>
                            <option value="" disabled selected>-- Pilih Status Pegawai --</option>
                            <option value="Percobaan">Percobaan (3 Bulan, Gaji 80%)</option>
                            <option value="Aktif">Aktif (Gaji 100%)</option>
                        </select>
                        <small class="form-text text-muted">
                            <strong>Percobaan:</strong> Masa percobaan 3 bulan dengan gaji 80% dari gaji pokok<br>
                            <strong>Aktif:</strong> Pegawai aktif dengan gaji 100%
                        </small>
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

                    <!-- inputan gaji pokok -->
                    <div class="form-group">
                        <label for="input_gaji_pokok">Gaji Pokok (100%) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="input_gaji_pokok" name="gaji_pokok" placeholder="Contoh: 2050000" value="<?= old('gaji_pokok') ?>" required>
                        <small class="form-text text-muted">
                            Gaji pokok 100% yang akan diterima pegawai aktif<br>
                            <strong>Format:</strong> Angka saja tanpa titik/koma. Contoh: 2050000 untuk Rp 2.050.000
                        </small>
                    </div>

                    <!-- Display gaji yang diterima (read-only) -->
                    <div class="form-group">
                        <label for="display_gaji_diterima">Gaji Yang Diterima</label>
                        <input type="text" class="form-control bg-light" id="display_gaji_diterima" readonly placeholder="Akan dihitung otomatis">
                        <small class="form-text text-muted">
                            <span id="info_gaji_percobaan" style="display:none;" class="text-warning">
                                <i class="mdi mdi-alert-circle"></i> Masa percobaan: Gaji 80% dari gaji pokok
                            </span>
                            <span id="info_gaji_aktif" style="display:none;" class="text-success">
                                <i class="mdi mdi-check-circle"></i> Pegawai aktif: Gaji 100% dari gaji pokok
                            </span>
                        </small>
                    </div>

                    <!-- Info masa percobaan (hanya tampil jika status Percobaan) -->
                    <div class="form-group" id="info_masa_percobaan" style="display:none;">
                        <div class="alert alert-info">
                            <strong><i class="mdi mdi-information"></i> Informasi Masa Percobaan:</strong><br>
                            <small>
                                • Durasi: 3 bulan dari TMT Kerja<br>
                                • Mulai: <span id="masa_percobaan_mulai">-</span><br>
                                • Selesai: <span id="masa_percobaan_selesai">-</span><br>
                                • Setelah masa percobaan selesai, status dapat diubah menjadi Aktif dengan gaji 100%
                            </small>
                        </div>
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
                        <small class="form-text text-muted" id="info_tst">
                            <span id="info_tst_percobaan" style="display:none;" class="text-warning">
                                <i class="mdi mdi-alert-circle"></i> Untuk pegawai percobaan, TST akan otomatis disesuaikan dengan masa percobaan selesai (3 bulan)
                            </span>
                        </small>
                    </div>

                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="<?= site_url('riwayat_kerja/riwayat/' . $id_pekerja_encrypted) ?>" class="btn btn-dark">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>



<script>
// Hitung gaji yang diterima berdasarkan status pegawai dan gaji pokok
function hitungGajiDiterima() {
    const statusPegawai = document.getElementById('input_status_pegawai').value;
    let gajiPokokInput = document.getElementById('input_gaji_pokok').value;
    
    // Hapus semua karakter non-digit (titik, koma, dll)
    gajiPokokInput = gajiPokokInput.replace(/\D/g, '');
    
    const gajiPokok = parseFloat(gajiPokokInput) || 0;
    const displayGaji = document.getElementById('display_gaji_diterima');
    const infoPercobaanEl = document.getElementById('info_gaji_percobaan');
    const infoAktifEl = document.getElementById('info_gaji_aktif');
    const infoMasaPercobaan = document.getElementById('info_masa_percobaan');
    
    // Update input dengan nilai yang sudah dibersihkan
    if (gajiPokokInput) {
        document.getElementById('input_gaji_pokok').value = gajiPokokInput;
    }
    
    if (gajiPokok > 0 && statusPegawai) {
        let gajiDiterima = gajiPokok;
        
        if (statusPegawai === 'Percobaan') {
            gajiDiterima = gajiPokok * 0.8;
            infoPercobaanEl.style.display = 'inline';
            infoAktifEl.style.display = 'none';
            infoMasaPercobaan.style.display = 'block';
            hitungMasaPercobaan();
        } else if (statusPegawai === 'Aktif') {
            gajiDiterima = gajiPokok;
            infoPercobaanEl.style.display = 'none';
            infoAktifEl.style.display = 'inline';
            infoMasaPercobaan.style.display = 'none';
        }
        
        displayGaji.value = 'Rp ' + gajiDiterima.toLocaleString('id-ID');
    } else {
        displayGaji.value = '';
        infoPercobaanEl.style.display = 'none';
        infoAktifEl.style.display = 'none';
        infoMasaPercobaan.style.display = 'none';
    }
}

// Hitung masa percobaan (3 bulan dari TMT)
function hitungMasaPercobaan() {
    const tmtKerja = document.getElementById('input_tmt').value;
    const tstInput = document.getElementById('input_tst');
    const infoTstPercobaan = document.getElementById('info_tst_percobaan');
    
    if (tmtKerja) {
        const tmtDate = new Date(tmtKerja);
        const selesaiDate = new Date(tmtDate);
        selesaiDate.setMonth(selesaiDate.getMonth() + 3);
        
        // Format tanggal untuk input date (YYYY-MM-DD)
        const selesaiFormatted = selesaiDate.toISOString().split('T')[0];
        
        // Format tanggal untuk display
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        document.getElementById('masa_percobaan_mulai').textContent = tmtDate.toLocaleDateString('id-ID', options);
        document.getElementById('masa_percobaan_selesai').textContent = selesaiDate.toLocaleDateString('id-ID', options);
        
        // Set TST otomatis = masa percobaan selesai
        tstInput.value = selesaiFormatted;
        tstInput.readOnly = true; // Readonly untuk percobaan
        infoTstPercobaan.style.display = 'inline';
    }
}

// Update TST handler
function updateTstStatus() {
    const statusPegawai = document.getElementById('input_status_pegawai').value;
    const tstInput = document.getElementById('input_tst');
    const infoTstPercobaan = document.getElementById('info_tst_percobaan');
    
    if (statusPegawai === 'Percobaan') {
        // Jika percobaan, calculate TST dari TMT
        hitungMasaPercobaan();
    } else {
        // Jika aktif, TST bisa diinput manual
        tstInput.readOnly = false;
        infoTstPercobaan.style.display = 'none';
    }
}

// Event listeners
document.getElementById('input_status_pegawai').addEventListener('change', function() {
    hitungGajiDiterima();
    updateTstStatus();
});
document.getElementById('input_gaji_pokok').addEventListener('input', hitungGajiDiterima);
document.getElementById('input_tmt').addEventListener('change', function() {
    if (document.getElementById('input_status_pegawai').value === 'Percobaan') {
        hitungMasaPercobaan();
    }
});
</script>

<?= $this->endSection() ?>