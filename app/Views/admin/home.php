<?= $this->extend('dashboard/main') ?>
<?= $this->section('content') ?>

<style>
    canvas {
        max-height: 250px !important;
        width: 100% !important;
    }
</style>

<div class="row mb-4 g-2">
    <div class="card p-3 shadow-sm rounded-3">
        <div class="col d-flex justify-content-between align-items-center">
            <h4 class="fw-bold m-0"><i class="bi bi-speedometer2 me-2"></i>Dashboard</h4>
            <span class="badge bg-success rounded">Terakhir Update: <?= date('d M Y') ?></span>
        </div>
    </div>
</div>

<!-- Statistik Demografi -->
<h6 class="text-primary mt-4 mb-2"><i class="bi bi-people-fill me-1"></i> Statistik Demografi</h6>
<div class="row row-cols-1 row-cols-md-4 g-3">
    <div class="col">
        <div class="card shadow-sm h-100 border-start border-4 border-primary rounded-3">
            <div class="card-body d-flex flex-column justify-content-between">
                <h6 class="fw-bold">Jenis Kelamin</h6>
                <p class="mb-2">Laki-Laki <?= countGenderActive('L') ?><br>
                    <span class="text-danger">Perempuan <?= countGenderActive('P') ?></span>
                </p>
                <a href="#" class="btn btn-sm btn-outline-primary mt-auto" data-bs-toggle="modal" data-bs-target="#modalGender">Lihat Detail</a>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card shadow-sm h-100 border-start border-4 border-success rounded-3">
            <div class="card-body d-flex flex-column justify-content-between">
                <h6 class="fw-bold">Rentang Umur</h6>
                <p class="mb-2">Total <?= ageRangeActive()['total'] ?> Orang</p>
                <a href="#" class="btn btn-sm btn-outline-primary mt-auto" data-bs-toggle="modal" data-bs-target="#modalUmur">Lihat Detail</a>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card shadow-sm h-100 border-start border-4 border-warning rounded-3">
            <div class="card-body d-flex flex-column justify-content-between">
                <h6 class="fw-bold">Pendidikan</h6>
                <p class="mb-2"><?= countTingkatPendidikan() ?></p>
                <a href="#" class="btn btn-sm btn-outline-primary mt-auto" data-bs-toggle="modal" data-bs-target="#modalPendidikan">Lihat Detail</a>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card shadow-sm h-100 border-start border-4 border-info rounded-3">
            <div class="card-body d-flex flex-column justify-content-between">
                <h6 class="fw-bold">Unit Bidang</h6>
                <p class="mb-2">
                    <?php if (strtolower(session()->get('unitKerja')) == 'dinas lingkungan hidup') : ?>
                        <?= countUnitBidang() ?> Unit Bidang
                    <?php else : ?>
                        <?= session()->get('unitKerja') ?>
                    <?php endif; ?>
                </p>
                <a href="#" class="btn btn-sm btn-outline-primary mt-auto" data-bs-toggle="modal" data-bs-target="#modalBidang">Lihat Detail</a>
            </div>
        </div>
    </div>
</div>

<!-- Diagram Depan -->
<div class="row g-3 mt-4">
    <div class="col-md-6">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h6 class="fw-bold">Visualisasi Rentang Umur</h6>
                <canvas id="umurChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h6 class="fw-bold">Visualisasi Jenis Kelamin</h6>
                <canvas id="genderChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h6 class="fw-bold">Visualisasi Pendidikan</h6>
                <canvas id="pendidikanChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h6 class="fw-bold">Visualisasi Unit Kerja</h6>
                <canvas id="unitChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Jenis Kelamin -->
<div class="modal fade" id="modalGender" tabindex="-1" aria-labelledby="modalGenderLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalGenderLabel">Detail Jenis Kelamin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="mb-4 col-3">
                    <canvas id="genderChartModal"></canvas>
                </div>
                <h6 class="fw-bold">Tabel Informasi</h6>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Jenis Kelamin</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Laki-Laki</td>
                            <td><?= countGenderActive('L') ?></td>
                        </tr>
                        <tr>
                            <td>Perempuan</td>
                            <td><?= countGenderActive('P') ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Rentang Umur -->
<div class="modal fade" id="modalUmur" tabindex="-1" aria-labelledby="modalUmurLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalUmurLabel">Detail Rentang Umur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="mb-4 col-6">
                    <canvas id="umurChartModal"></canvas>
                </div>
                <h6 class="fw-bold">Tabel Informasi</h6>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Rentang Umur</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (ageRangeActive() as $range => $jumlah) :
                            if ($range !== 'total') : ?>
                                <tr>
                                    <td><?= $range ?></td>
                                    <td><?= $jumlah ?></td>
                                </tr>
                        <?php endif;
                        endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Pendidikan -->
<div class="modal fade" id="modalPendidikan" tabindex="-1" aria-labelledby="modalPendidikanLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPendidikanLabel">Detail Pendidikan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="mb-4 col-3">
                    <canvas id="pendidikanChartModal"></canvas>
                </div>
                <h6 class="fw-bold">Tabel Informasi</h6>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tingkat Pendidikan</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (countTingkatPendidikanRaw() as $tingkat => $jumlah) : ?>
                            <tr>
                                <td><?= $tingkat ?></td>
                                <td><?= $jumlah ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- Modal Detail Unit Bidang -->
<div class="modal fade" id="modalBidang" tabindex="-1" aria-labelledby="modalBidangLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalBidangLabel">Detail Unit Bidang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="mb-4 col-3">
                    <canvas id="unitChartModal"></canvas>
                </div>
                <h6 class="fw-bold">Tabel Informasi</h6>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Unit Bidang</th>
                            <th>Jumlah Pegawai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (getUnitKerjaWithJumlahPegawai() as $bidang => $jumlah) : ?>
                            <tr>
                                <td><?= $bidang ?></td>
                                <td><?= $jumlah ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Load Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const umurChart = new Chart(document.getElementById('umurChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: ['18-25', '26-35', '36-45', '46-55', '56-60'],
            datasets: [{
                label: 'Jumlah Pegawai',
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                data: [<?= ageRangeActive()['18-25'] ?>, <?= ageRangeActive()['26-35'] ?>, <?= ageRangeActive()['36-45'] ?>, <?= ageRangeActive()['46-55'] ?>, <?= ageRangeActive()['56-60'] ?>]
            }]
        }
    });

    const genderChart = new Chart(document.getElementById('genderChart').getContext('2d'), {
        type: 'pie',
        data: {
            labels: ['Laki-Laki', 'Perempuan'],
            datasets: [{
                backgroundColor: ['#36A2EB', '#FF6384'],
                data: [<?= countGenderActive('L') ?>, <?= countGenderActive('P') ?>]
            }]
        }
    });

    const pendidikanChart = new Chart(document.getElementById('pendidikanChart').getContext('2d'), {
        type: 'pie',
        data: {
            labels: <?= json_encode(array_keys(countTingkatPendidikanRaw())) ?>,
            datasets: [{
                backgroundColor: ['#4BC0C0', '#FF9F40', '#9966FF', '#FFCD56', '#36A2EB'],
                data: <?= json_encode(array_values(countTingkatPendidikanRaw())) ?>
            }]
        }
    });

    const unitChart = new Chart(document.getElementById('unitChart').getContext('2d'), {
        type: 'pie',
        data: {
            labels: <?= json_encode(array_keys(getUnitKerjaWithJumlahPegawai())) ?>,
            datasets: [{
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'],
                data: <?= json_encode(array_values(getUnitKerjaWithJumlahPegawai())) ?>
            }]
        }
    });

    const genderChartModal = new Chart(document.getElementById('genderChartModal').getContext('2d'), {
        type: 'pie',
        data: {
            labels: ['Laki-Laki', 'Perempuan'],
            datasets: [{
                backgroundColor: ['#36A2EB', '#FF6384'],
                data: [<?= countGenderActive('L') ?>, <?= countGenderActive('P') ?>]
            }]
        }
    });

    const umurChartModal = new Chart(document.getElementById('umurChartModal').getContext('2d'), {
        type: 'bar',
        data: {
            labels: ['18-25', '26-35', '36-45', '46-55', '56-60'],
            datasets: [{
                label: 'Jumlah Pegawai',
                backgroundColor: 'rgba(255, 99, 132, 0.6)',
                data: [<?= ageRangeActive()['18-25'] ?>, <?= ageRangeActive()['26-35'] ?>, <?= ageRangeActive()['36-45'] ?>, <?= ageRangeActive()['46-55'] ?>, <?= ageRangeActive()['56-60'] ?>]
            }]
        }
    });

    const pendidikanChartModal = new Chart(document.getElementById('pendidikanChartModal').getContext('2d'), {
        type: 'pie',
        data: {
            labels: <?= json_encode(array_keys(countTingkatPendidikanRaw())) ?>,
            datasets: [{
                backgroundColor: ['#FF9F40', '#4BC0C0', '#9966FF', '#FFCD56', '#36A2EB'],
                data: <?= json_encode(array_values(countTingkatPendidikanRaw())) ?>
            }]
        }
    });

    const unitChartModal = new Chart(document.getElementById('unitChartModal').getContext('2d'), {
        type: 'pie',
        data: {
            labels: <?= json_encode(array_keys(getUnitKerjaWithJumlahPegawai())) ?>,
            datasets: [{
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'],
                data: <?= json_encode(array_values(getUnitKerjaWithJumlahPegawai())) ?>
            }]
        }
    });
</script>


<?= $this->endSection() ?>