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

                    <!-- Status Pegawai -->
                    <div class="form-group">
                        <label for="input_status_pegawai">Status Pegawai <span class="text-danger">*</span></label>
                        <select class="form-control" id="input_status_pegawai" name="status_pegawai" required>
                            <option value="" disabled>-- Pilih Status Pegawai --</option>
                            <option value="Percobaan" 
                                <?= old('status_pegawai', $riwayat['status_pegawai'] ?? 'Aktif') == 'Percobaan' ? 'selected' : '' ?>>
                                Percobaan (3 Bulan, Gaji 80%)
                            </option>
                            <option value="Aktif"
                                <?= old('status_pegawai', $riwayat['status_pegawai'] ?? 'Aktif') == 'Aktif' ? 'selected' : '' ?>>
                                Aktif (Gaji 100%)
                            </option>
                        </select>
                        <small class="form-text text-muted">
                            <strong>Percobaan:</strong> Masa percobaan 3 bulan dengan gaji 80% dari gaji pokok<br>
                            <strong>Aktif:</strong> Pegawai aktif dengan gaji 100%
                        </small>
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

                    <!-- gaji pokok -->
                    <div class="form-group">
                        <label for="input_gaji_pokok">Gaji Pokok (100%) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="input_gaji_pokok" name="gaji_pokok"
                            value="<?= old('gaji_pokok', (int) ($riwayat['gaji_pokok'] ?? $riwayat['gaji'])) ?>" required>
                        <small class="form-text text-muted">Gaji pokok 100% yang akan diterima pegawai aktif</small>
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

<script>
// Hitung gaji yang diterima berdasarkan status pegawai dan gaji pokok
function hitungGajiDiterima() {
    const statusPegawai = document.getElementById('input_status_pegawai').value;
    const gajiPokok = parseFloat(document.getElementById('input_gaji_pokok').value) || 0;
    const displayGaji = document.getElementById('display_gaji_diterima');
    const infoPercobaanEl = document.getElementById('info_gaji_percobaan');
    const infoAktifEl = document.getElementById('info_gaji_aktif');
    const infoMasaPercobaan = document.getElementById('info_masa_percobaan');
    
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
    
    if (tmtKerja) {
        const tmtDate = new Date(tmtKerja);
        const selesaiDate = new Date(tmtDate);
        selesaiDate.setMonth(selesaiDate.getMonth() + 3);
        
        // Format tanggal
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        document.getElementById('masa_percobaan_mulai').textContent = tmtDate.toLocaleDateString('id-ID', options);
        document.getElementById('masa_percobaan_selesai').textContent = selesaiDate.toLocaleDateString('id-ID', options);
    }
}

// Event listeners
document.getElementById('input_status_pegawai').addEventListener('change', hitungGajiDiterima);
document.getElementById('input_gaji_pokok').addEventListener('input', hitungGajiDiterima);
document.getElementById('input_tmt').addEventListener('change', function() {
    if (document.getElementById('input_status_pegawai').value === 'Percobaan') {
        hitungMasaPercobaan();
    }
});

// Jalankan saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    hitungGajiDiterima();
});
</script>

<?= $this->endSection() ?>