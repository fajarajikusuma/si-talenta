<?= $this->extend('dashboard/main') ?>
<?= $this->section('content') ?>

<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Generate Nomor SK Tahun <?= esc($noSk['tahun']) ?></h4>

            <div class="alert alert-light border mb-3">
                <div class="row">
                    <div class="col-md-4">
                        <strong>Kode SK:</strong> <?= esc($noSk['kode_sk']) ?>
                    </div>
                    <div class="col-md-4">
                        <strong>Nomor Utama:</strong> <?= esc($noSk['nomor_utama']) ?>
                    </div>
                    <div class="col-md-4">
                        <strong>Awalan Nomor:</strong> <?= esc($noSk['awalan_nomor']) ?>
                    </div>
                </div>
            </div>

            <div class="alert alert-info">
                <strong>ℹ️ Informasi Penting:</strong> 
                <ul class="mb-0">
                    <li><strong>Filter Otomatis:</strong> Hanya menampilkan pegawai yang <u>BELUM memiliki nomor SK di tahun <?= esc($noSk['tahun']) ?></u></li>
                    <li><strong>Mode Otomatis:</strong> Generate nomor SK untuk semua pegawai dalam daftar</li>
                    <li><strong>Mode Selektif:</strong> Pilih pegawai tertentu yang ingin digenerate nomor SK-nya</li>
                    <li><strong>Data Historis Aman:</strong> Pegawai yang sudah punya nomor SK di tahun ini tidak ditampilkan</li>
                </ul>
            </div>

            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (empty($pegawaiAktif)): ?>
                <div class="alert alert-warning">
                    <strong>⚠️ Perhatian:</strong> Semua pegawai aktif sudah memiliki nomor SK di tahun <?= esc($noSk['tahun']) ?>. 
                    Tidak ada pegawai yang perlu digenerate nomor SK.
                </div>
                <div class="mt-3">
                    <a href="<?= site_url('no-sk/detail/' . $id_enc) ?>" class="btn btn-secondary">
                        <i class="mdi mdi-arrow-left"></i> Kembali
                    </a>
                </div>
            <?php else: ?>

            <form action="<?= site_url('no-sk/generate-process/' . $id_enc) ?>" method="POST" id="formGenerate">
                <?= csrf_field() ?>

                <div class="row">
                    <!-- Mode Generate -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label mb-2"><strong>Pilih Mode Generate</strong></label>
                        <div class="form-check d-flex align-items-center gap-2">
                            <input class="form-check-input m-0" type="radio" name="mode" id="modeOtomatis" value="otomatis" checked style="position: static; margin-left: 0;">
                            <label class="form-check-label m-0" for="modeOtomatis">
                                <strong>Otomatis</strong> - Generate untuk semua pegawai
                            </label>
                        </div>
                        <div class="form-check d-flex align-items-center gap-2 mt-2">
                            <input class="form-check-input m-0" type="radio" name="mode" id="modeSelektif" value="selektif" style="position: static; margin-left: 0;">
                            <label class="form-check-label m-0" for="modeSelektif">
                                <strong>Selektif</strong> - Pilih pegawai tertentu
                            </label>
                        </div>
                    </div>

                    <!-- Tanggal Penetapan SK -->
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_penetapan" class="form-label mb-2"><strong>Tanggal Penetapan SK</strong></label>
                        <input type="date" class="form-control bg-light" id="tanggal_penetapan" name="tanggal_penetapan" 
                               value="<?= $noSk['tanggal_penetapan'] ?>" required readonly>
                        <small class="form-text text-muted">Nomor SK akan dikelompokkan berdasarkan tanggal ini</small>
                    </div>
                </div>

                <!-- Daftar Pegawai (untuk mode selektif) -->
                <div id="divSelektif" style="display: none;">
                    <div class="mb-3">
                        <label class="form-label mb-2"><strong>Pilih Pegawai</strong></label>
                        <div class="alert alert-light border py-2 px-3">
                            <div class="form-check d-flex align-items-center gap-2 m-0">
                                <input class="form-check-input m-0" type="checkbox" id="checkAll" style="position: static; margin-left: 0;">
                                <label class="form-check-label m-0 p-0" for="checkAll">
                                    <strong>Pilih Semua (<?= count($pegawaiAktif) ?> pegawai)</strong>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover" id="tablePegawaiGenerate">
                            <thead class="table-primary">
                                <tr>
                                    <th width="50" class="text-center align-middle">
                                        <input type="checkbox" id="checkAllTable" class="form-check-input m-0" style="position: static; margin-left: 0;">
                                    </th>
                                    <th width="150">ID Pegawai</th>
                                    <th>Nama Pegawai</th>
                                    <th width="150" class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($pegawaiAktif)): ?>
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <em>Tidak ada pegawai yang perlu digenerate nomor SK</em>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($pegawaiAktif as $index => $p): ?>
                                        <tr>
                                            <td class="text-center align-middle">
                                                <input type="checkbox" 
                                                       name="selected_pegawai[]" 
                                                       value="<?= esc($p['id_pekerja']) ?>"
                                                       class="form-check-input checkbox-pegawai m-0"
                                                       style="position: static; margin-left: 0;">
                                            </td>
                                            <td class="align-middle"><?= esc($p['id_pekerja']) ?></td>
                                            <td class="align-middle"><?= esc($p['nama']) ?></td>
                                            <td class="text-center align-middle">
                                                <span class="badge bg-warning text-dark">Belum Ada SK</span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="d-flex flex-column flex-md-row gap-2 mb-3">
                    <button type="submit" class="btn btn-primary" id="btnSubmit">
                        <i class="mdi mdi-content-save"></i> Generate Nomor SK
                    </button>
                    <a href="<?= site_url('no-sk/detail/' . $id_enc) ?>" class="btn btn-secondary">
                        <i class="mdi mdi-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>

            <?php endif; // End if empty pegawaiAktif ?>
        </div>
    </div>
</div>

<?php if (!empty($pegawaiAktif)): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modeOtomatis = document.getElementById('modeOtomatis');
    const modeSelektif = document.getElementById('modeSelektif');
    const divSelektif = document.getElementById('divSelektif');
    const checkAll = document.getElementById('checkAll');
    const checkAllTable = document.getElementById('checkAllTable');

    // Initialize DataTable variable
    let tablePegawai = null;
    
    // Toggle tampilan daftar pegawai berdasarkan mode
    modeOtomatis.addEventListener('change', function() {
        if (this.checked) {
            divSelektif.style.display = 'none';
            // Destroy DataTable if exists
            if (tablePegawai) {
                tablePegawai.destroy();
                tablePegawai = null;
            }
        }
    });

    modeSelektif.addEventListener('change', function() {
        if (this.checked) {
            divSelektif.style.display = 'block';
            
            // Initialize DataTable menggunakan vanilla DataTable (bukan jQuery)
            setTimeout(function() {
                if (!tablePegawai && typeof DataTable !== 'undefined') {
                    try {
                        tablePegawai = new DataTable('#tablePegawaiGenerate', {
                            responsive: true,
                            ordering: true,
                            order: [[2, 'asc']], // Sort by nama
                            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Semua"]],
                            pageLength: 10,
                            language: {
                                lengthMenu: "Tampilkan _MENU_",
                                zeroRecords: "Data tidak ditemukan",
                                info: "Menampilkan halaman _PAGE_ dari _PAGES_",
                                infoEmpty: "Tidak ada data yang tersedia",
                                infoFiltered: "(difilter dari _MAX_ total data)",
                                search: "Cari:",
                                paginate: {
                                    first: "Pertama",
                                    last: "Terakhir",
                                    next: "Selanjutnya",
                                    previous: "Sebelumnya"
                                }
                            },
                            columnDefs: [
                                { 
                                    orderable: false, 
                                    targets: [0, 3] // Disable ordering on checkbox dan status
                                }
                            ]
                        });
                        
                        console.log('DataTable berhasil diinisialisasi!');
                        
                        // Re-bind checkbox events setelah DataTable init
                        bindCheckboxEvents();
                    } catch (error) {
                        console.warn('DataTable tidak dapat dimuat:', error);
                    }
                }
            }, 100);
        }
    });

    // Fungsi untuk check/uncheck all pegawai
    function toggleAllCheckboxes(checked) {
        const checkboxes = document.querySelectorAll('.checkbox-pegawai');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = checked;
        });
    }

    // Bind checkbox events
    function bindCheckboxEvents() {
        // Update status checkAll berdasarkan checkbox individual
        const updateCheckAllStatus = function() {
            const checkboxes = document.querySelectorAll('.checkbox-pegawai');
            const checkedBoxes = document.querySelectorAll('.checkbox-pegawai:checked');
            
            if (checkboxes.length > 0) {
                const allChecked = checkboxes.length === checkedBoxes.length;
                checkAll.checked = allChecked;
                checkAllTable.checked = allChecked;
            }
        };

        // Bind ke semua checkbox pegawai yang terlihat
        document.querySelectorAll('.checkbox-pegawai').forEach(function(checkbox) {
            checkbox.removeEventListener('change', updateCheckAllStatus);
            checkbox.addEventListener('change', updateCheckAllStatus);
        });
    }

    // Event listener untuk checkbox "Pilih Semua"
    checkAll.addEventListener('change', function() {
        toggleAllCheckboxes(this.checked);
        checkAllTable.checked = this.checked;
    });

    checkAllTable.addEventListener('change', function() {
        toggleAllCheckboxes(this.checked);
        checkAll.checked = this.checked;
    });

    // Initial bind
    bindCheckboxEvents();

    // Validasi form sebelum submit
    document.getElementById('formGenerate').addEventListener('submit', function(e) {
        const mode = document.querySelector('input[name="mode"]:checked').value;
        
        if (mode === 'selektif') {
            const checkedBoxes = document.querySelectorAll('.checkbox-pegawai:checked');
            
            if (checkedBoxes.length === 0) {
                e.preventDefault();
                alert('Pilih minimal satu pegawai untuk mode selektif!');
                return false;
            }
        }

        // Konfirmasi sebelum generate
        const confirmMsg = mode === 'otomatis' 
            ? 'Generate nomor SK untuk SEMUA pegawai (<?= count($pegawaiAktif) ?> orang)?' 
            : 'Generate nomor SK untuk pegawai yang dipilih (' + document.querySelectorAll('.checkbox-pegawai:checked').length + ' orang)?';
            
        if (!confirm(confirmMsg)) {
            e.preventDefault();
            return false;
        }
    });
});
</script>
<?php endif; ?>

<?= $this->endSection() ?>