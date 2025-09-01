<?= $this->extend('dashboard/main') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h4 class="card-title m-0 fw-bold">Ajukan Penugasan Baru</h4>
            </div>
        </div>
    </div>

    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <?php if (session()->getFlashdata('success')) : ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php elseif (session()->getFlashdata('error')) : ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <!-- Form untuk ajukan semua -->
                <div class="table-responsive">
                    <form action="<?= site_url('penugasan/ajukan_semua') ?>" method="post">
                        <h4 class="mb-4">Aktif di Tahun Sebelumnya</h4>
                        <table class="table table-bordered table-striped" id="tableDataPekerja">
                            <thead>
                                <!-- <tr>
                                    <th colspan="3"></th>
                                    <th colspan="2">Check all</th>
                                </tr> -->
                                <tr>
                                    <th width="100px" class="text-center">
                                        <div class="d-flex align-items-center justify-content-center flex-column">
                                            <label for="checkAll">Pilih Semua</label>
                                            <input type="checkbox" id="checkAll" class="mt-2">
                                        </div>
                                    </th>
                                    <th class="text-start">Nama</th>
                                    <th>Tanggal Lahir</th>
                                    <th>
                                        <b>Pekerjaan</b><br><br>
                                        <input type="checkbox" id="checkAllPekerjaanSama">
                                        <label for="checkAllPekerjaanSama" class="me-3">Sama</label>
                                        <input type="checkbox" id="checkAllPekerjaanTidak">
                                        <label for="checkAllPekerjaanTidak">Tidak</label>
                                    </th>
                                    <th>
                                        <b>Unit Kerja</b><br><br>
                                        <input type="checkbox" id="checkAllUnitSama">
                                        <label for="checkAllUnitSama" class="me-3">Sama</label>
                                        <input type="checkbox" id="checkAllUnitTidak">
                                        <label for="checkAllUnitTidak">Tidak</label>
                                    </th>
                                    <th>
                                        <b>Aktif Tahun Berikutnya</b><br><br>
                                        <input type="checkbox" id="checkAllAktif">
                                        <label for="checkAllAktif" class="me-3">Aktif</label>
                                        <input type="checkbox" id="checkAllNonAktif">
                                        <label for="checkAllNonAktif">Non Aktif</label>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dataPekerja as $pekerja): ?>
                                    <?php
                                    $id = $pekerja['id_pekerja'];
                                    // Ambil riwayat terakhir
                                    $last = null;
                                    foreach ($riwayatKerja as $r) {
                                        if ($r['id_pekerja'] == $id) {
                                            $last = $r;
                                            break;
                                        }
                                    }
                                    $lastPekerjaan = $last['id_nama_pekerjaan'] ?? '';
                                    $lastUnitKerja = $last['id_unit_kerja'] ?? '';
                                    ?>
                                    <tr>
                                        <td class="text-center"><input type="checkbox" class="check-item" name="selected[]" value="<?= $id ?>"></td>
                                        <td class="text-start"><?= esc($pekerja['nama']) ?></td>
                                        <td><?= date('d-m-Y', strtotime($pekerja['tanggal_lahir'])) ?></td>
                                        <td class="text-start">
                                            <div class="container">
                                                <div class="form-check">
                                                    <input class="form-check-input pekerjaan-sama" type="checkbox" name="pekerjaan_sama[<?= $id ?>]" value="<?= $lastPekerjaan ?>">
                                                    <label>Sama</label>
                                                </div>
                                                <div class="form-check mt-1">
                                                    <input class="form-check-input pekerjaan-tidak" type="checkbox" name="pekerjaan_tidak[<?= $id ?>]">
                                                    <label for="pekerjaan">Tidak</label>
                                                    <select class="form-select mt-1" name="pekerjaan_pilih[<?= $id ?>]" disabled id="pekerjaan">
                                                        <option value="" disabled selected>-- Pilih --</option>
                                                        <?php foreach ($listPekerjaan as $p): ?>
                                                            <option value="<?= $p['id_nama_pekerjaan'] ?>"><?= esc($p['pekerjaan']) ?></option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-start">
                                            <div class="container">
                                                <div class="form-check">
                                                    <input class="form-check-input unit-sama" type="checkbox" name="unit_sama[<?= $id ?>]" value="<?= $lastUnitKerja ?>">
                                                    <label>Sama</label>
                                                </div>
                                                <div class="form-check mt-1">
                                                    <input class="form-check-input unit-tidak" type="checkbox" name="unit_tidak[<?= $id ?>]">
                                                    <label for="unit_kerja">Tidak</label>
                                                    <select class="form-select mt-1" name="unit_pilih[<?= $id ?>]" disabled id="unit_kerja">
                                                        <option value="" selected disabled>-- Pilih --</option>
                                                        <?php foreach ($unitKerja as $u): ?>
                                                            <?php if ($u['unit_kerja'] !== 'Dinas Lingkungan Hidup') : ?>
                                                                <option value="<?= $u['id_unit_kerja'] ?>"><?= esc($u['unit_kerja']) ?></option>
                                                            <?php endif ?>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-start">
                                            <div class="container">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="form-check me-3">
                                                        <input class="form-check-input aktif" type="checkbox" name="aktif[<?= $id ?>]" value="1" id="aktif_<?= $id ?>">
                                                        <label class="form-check-label m-0" for="aktif_<?= $id ?>">Aktif</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input non-aktif" type="checkbox" name="non_aktif[<?= $id ?>]" value="0" id="non_aktif_<?= $id ?>">
                                                        <label class="form-check-label m-0" for="non_aktif_<?= $id ?>">Non Aktif</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>

                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-primary">Ajukan Semua</button>
                        </div>
                    </form>
                </div>


                <!-- Script check all -->
                <script>
                    // Checkbox utama
                    document.getElementById('checkAll').addEventListener('change', function() {
                        document.querySelectorAll('.check-item').forEach(cb => cb.checked = this.checked);
                    });

                    // Master check untuk pekerjaan
                    document.getElementById('checkAllPekerjaanSama').addEventListener('change', function() {
                        document.querySelectorAll('.pekerjaan-sama').forEach(cb => cb.checked = this.checked);
                    });
                    document.getElementById('checkAllPekerjaanTidak').addEventListener('change', function() {
                        document.querySelectorAll('.pekerjaan-tidak').forEach(cb => cb.checked = this.checked);
                        document.querySelectorAll('select[name^="pekerjaan_pilih"]').forEach(sel => sel.disabled = !this.checked);
                    });

                    // Master check untuk unit
                    document.getElementById('checkAllUnitSama').addEventListener('change', function() {
                        document.querySelectorAll('.unit-sama').forEach(cb => cb.checked = this.checked);
                    });
                    document.getElementById('checkAllUnitTidak').addEventListener('change', function() {
                        document.querySelectorAll('.unit-tidak').forEach(cb => cb.checked = this.checked);
                        document.querySelectorAll('select[name^="unit_pilih"]').forEach(sel => sel.disabled = !this.checked);
                    });

                    // Master check untuk aktif/non-aktif
                    document.getElementById('checkAllAktif').addEventListener('change', function() {
                        document.querySelectorAll('.aktif').forEach(cb => cb.checked = this.checked);
                    });
                    document.getElementById('checkAllNonAktif').addEventListener('change', function() {
                        document.querySelectorAll('.non-aktif').forEach(cb => cb.checked = this.checked);
                    });

                    // Enable/disable per baris select pekerjaan
                    document.querySelectorAll('.pekerjaan-tidak').forEach(cb => {
                        cb.addEventListener('change', function() {
                            this.closest('td').querySelector('select').disabled = !this.checked;
                        });
                    });

                    // Enable/disable per baris select unit
                    document.querySelectorAll('.unit-tidak').forEach(cb => {
                        cb.addEventListener('change', function() {
                            this.closest('td').querySelector('select').disabled = !this.checked;
                        });
                    });
                </script>

                <script>
                    // Saat centang pekerjaan
                    document.querySelectorAll('.check-pekerjaan').forEach(cb => {
                        cb.addEventListener('change', function() {
                            const id = this.dataset.id;
                            const hiddenInput = document.getElementById('pekerjaan-' + id);
                            const lastValue = document.getElementById('last-pekerjaan-' + id).value;
                            hiddenInput.value = this.checked ? lastValue : '';
                            // jika form per baris
                            document.getElementById('form-pekerjaan-' + id).value = hiddenInput.value;
                        });
                    });

                    // Saat centang unit kerja
                    document.querySelectorAll('.check-unit').forEach(cb => {
                        cb.addEventListener('change', function() {
                            const id = this.dataset.id;
                            const hiddenInput = document.getElementById('unit-' + id);
                            const lastValue = document.getElementById('last-unit-' + id).value;
                            hiddenInput.value = this.checked ? lastValue : '';
                            // jika form per baris
                            document.getElementById('form-unit-' + id).value = hiddenInput.value;
                        });
                    });

                    // Check all update
                    document.getElementById('checkAllPekerjaan')?.addEventListener('change', function(e) {
                        document.querySelectorAll('.check-pekerjaan').forEach(cb => {
                            cb.checked = e.target.checked;
                            cb.dispatchEvent(new Event('change'));
                        });
                    });

                    document.getElementById('checkAllUnit')?.addEventListener('change', function(e) {
                        document.querySelectorAll('.check-unit').forEach(cb => {
                            cb.checked = e.target.checked;
                            cb.dispatchEvent(new Event('change'));
                        });
                    });
                </script>

                <script>
                    // === FUNGSI CHECK ALL ===
                    document.getElementById('checkAll').addEventListener('change', function() {
                        document.querySelectorAll('.check-item').forEach(cb => cb.checked = this.checked);
                    });

                    // === PEKERJAAN SAMA/TIDAK ===
                    document.getElementById('checkAllPekerjaanSama').addEventListener('change', function() {
                        document.querySelectorAll('.pekerjaan-sama').forEach(cb => {
                            if (!cb.disabled) cb.checked = this.checked;
                        });
                    });

                    document.getElementById('checkAllPekerjaanTidak').addEventListener('change', function() {
                        document.querySelectorAll('.pekerjaan-tidak').forEach(cb => {
                            if (!cb.disabled) cb.checked = this.checked;
                        });
                        document.querySelectorAll('select[name^="pekerjaan_pilih"]').forEach(sel => {
                            sel.disabled = !this.checked;
                        });
                    });

                    // === UNIT KERJA SAMA/TIDAK ===
                    document.getElementById('checkAllUnitSama').addEventListener('change', function() {
                        document.querySelectorAll('.unit-sama').forEach(cb => {
                            if (!cb.disabled) cb.checked = this.checked;
                        });
                    });

                    document.getElementById('checkAllUnitTidak').addEventListener('change', function() {
                        document.querySelectorAll('.unit-tidak').forEach(cb => {
                            if (!cb.disabled) cb.checked = this.checked;
                        });
                        document.querySelectorAll('select[name^="unit_pilih"]').forEach(sel => {
                            sel.disabled = !this.checked;
                        });
                    });

                    // === AKTIF/NON AKTIF ===
                    document.getElementById('checkAllAktif').addEventListener('change', function() {
                        document.querySelectorAll('.aktif').forEach(cb => cb.checked = this.checked);
                    });

                    document.getElementById('checkAllNonAktif').addEventListener('change', function() {
                        document.querySelectorAll('.non-aktif').forEach(cb => cb.checked = this.checked);
                        updateCheckboxState(); // penting agar disable checkbox lainnya
                    });

                    // === PER-BARIS: aktifkan select jika "tidak sama" dicentang ===
                    document.querySelectorAll('.pekerjaan-tidak').forEach(cb => {
                        cb.addEventListener('change', function() {
                            this.closest('td').querySelector('select').disabled = !this.checked;
                        });
                    });

                    document.querySelectorAll('.unit-tidak').forEach(cb => {
                        cb.addEventListener('change', function() {
                            this.closest('td').querySelector('select').disabled = !this.checked;
                        });
                    });

                    // === NON AKTIF: disable pilihan pekerjaan & unit kerja ===
                    function updateCheckboxState() {
                        document.querySelectorAll('tbody tr').forEach(row => {
                            const nonAktif = row.querySelector('.non-aktif');
                            const pekerjaanSama = row.querySelector('.pekerjaan-sama');
                            const pekerjaanTidak = row.querySelector('.pekerjaan-tidak');
                            const pekerjaanSelect = row.querySelector('select[name^="pekerjaan_pilih"]');
                            const unitSama = row.querySelector('.unit-sama');
                            const unitTidak = row.querySelector('.unit-tidak');
                            const unitSelect = row.querySelector('select[name^="unit_pilih"]');

                            if (nonAktif?.checked) {
                                // Hapus semua centang dan disable semua elemen terkait
                                if (pekerjaanSama) {
                                    pekerjaanSama.checked = false;
                                    pekerjaanSama.disabled = true;
                                }
                                if (pekerjaanTidak) {
                                    pekerjaanTidak.checked = false;
                                    pekerjaanTidak.disabled = true;
                                }
                                if (pekerjaanSelect) {
                                    pekerjaanSelect.value = "";
                                    pekerjaanSelect.disabled = true;
                                }

                                if (unitSama) {
                                    unitSama.checked = false;
                                    unitSama.disabled = true;
                                }
                                if (unitTidak) {
                                    unitTidak.checked = false;
                                    unitTidak.disabled = true;
                                }
                                if (unitSelect) {
                                    unitSelect.value = "";
                                    unitSelect.disabled = true;
                                }
                            } else {
                                // Aktifkan kembali jika "Non Aktif" tidak dicentang
                                if (pekerjaanSama) pekerjaanSama.disabled = false;
                                if (pekerjaanTidak) pekerjaanTidak.disabled = false;
                                if (pekerjaanTidak?.checked) pekerjaanSelect.disabled = false;

                                if (unitSama) unitSama.disabled = false;
                                if (unitTidak) unitTidak.disabled = false;
                                if (unitTidak?.checked) unitSelect.disabled = false;
                            }
                        });
                    }
                    // Jalankan saat halaman pertama kali dimuat
                    updateCheckboxState();

                    // Trigger update saat checkbox "non-aktif" dicentang/ubah
                    document.querySelectorAll('.non-aktif').forEach(cb => {
                        cb.addEventListener('change', updateCheckboxState);
                    });
                </script>
                <script>
                    // Hanya satu centang: pekerjaan
                    document.querySelectorAll('tbody tr').forEach(row => {
                        const pekerjaanSama = row.querySelector('.pekerjaan-sama');
                        const pekerjaanTidak = row.querySelector('.pekerjaan-tidak');

                        if (pekerjaanSama && pekerjaanTidak) {
                            pekerjaanSama.addEventListener('change', function() {
                                if (this.checked) {
                                    pekerjaanTidak.checked = false;
                                    row.querySelector('select[name^="pekerjaan_pilih"]').disabled = true;
                                }
                            });

                            pekerjaanTidak.addEventListener('change', function() {
                                if (this.checked) {
                                    pekerjaanSama.checked = false;
                                    row.querySelector('select[name^="pekerjaan_pilih"]').disabled = false;
                                } else {
                                    row.querySelector('select[name^="pekerjaan_pilih"]').disabled = true;
                                }
                            });
                        }

                        const unitSama = row.querySelector('.unit-sama');
                        const unitTidak = row.querySelector('.unit-tidak');

                        if (unitSama && unitTidak) {
                            unitSama.addEventListener('change', function() {
                                if (this.checked) {
                                    unitTidak.checked = false;
                                    row.querySelector('select[name^="unit_pilih"]').disabled = true;
                                }
                            });

                            unitTidak.addEventListener('change', function() {
                                if (this.checked) {
                                    unitSama.checked = false;
                                    row.querySelector('select[name^="unit_pilih"]').disabled = false;
                                } else {
                                    row.querySelector('select[name^="unit_pilih"]').disabled = true;
                                }
                            });
                        }

                        const aktif = row.querySelector('.aktif');
                        const nonAktif = row.querySelector('.non-aktif');

                        if (aktif && nonAktif) {
                            aktif.addEventListener('change', function() {
                                if (this.checked) {
                                    nonAktif.checked = false;
                                    updateCheckboxState();
                                }
                            });

                            nonAktif.addEventListener('change', function() {
                                if (this.checked) {
                                    aktif.checked = false;
                                    updateCheckboxState();
                                }
                            });
                        }
                    });
                </script>

                <script>
                    function exclusiveHeaderCheckbox(idCheckSama, idCheckTidak, classSama, classTidak, selectNamePrefix = null) {
                        const checkSama = document.getElementById(idCheckSama);
                        const checkTidak = document.getElementById(idCheckTidak);

                        checkSama?.addEventListener('change', function() {
                            if (this.checked) {
                                checkTidak.checked = false;
                                document.querySelectorAll('.' + classSama).forEach(cb => cb.checked = true);
                                document.querySelectorAll('.' + classTidak).forEach(cb => cb.checked = false);
                                if (selectNamePrefix) {
                                    document.querySelectorAll(`select[name^="${selectNamePrefix}"]`).forEach(sel => sel.disabled = true);
                                }
                            }
                        });

                        checkTidak?.addEventListener('change', function() {
                            if (this.checked) {
                                checkSama.checked = false;
                                document.querySelectorAll('.' + classTidak).forEach(cb => cb.checked = true);
                                document.querySelectorAll('.' + classSama).forEach(cb => cb.checked = false);
                                if (selectNamePrefix) {
                                    document.querySelectorAll(`select[name^="${selectNamePrefix}"]`).forEach(sel => sel.disabled = false);
                                }
                            } else {
                                // Jika uncheck, disable select
                                if (selectNamePrefix) {
                                    document.querySelectorAll(`select[name^="${selectNamePrefix}"]`).forEach(sel => sel.disabled = true);
                                }
                            }
                        });
                    }

                    // Terapkan untuk semua bagian
                    exclusiveHeaderCheckbox('checkAllPekerjaanSama', 'checkAllPekerjaanTidak', 'pekerjaan-sama', 'pekerjaan-tidak', 'pekerjaan_pilih');
                    exclusiveHeaderCheckbox('checkAllUnitSama', 'checkAllUnitTidak', 'unit-sama', 'unit-tidak', 'unit_pilih');
                    exclusiveHeaderCheckbox('checkAllAktif', 'checkAllNonAktif', 'aktif', 'non-aktif');
                </script>

            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>