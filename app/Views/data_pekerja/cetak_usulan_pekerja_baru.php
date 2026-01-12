<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Cetak Usulan Baru</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 8px;
            border: 1px solid #000;
            text-align: left;
            vertical-align: top;
        }

        h2,
        p {
            text-align: center;
        }

        @media print {
            @page {
                size: portrait;
            }
        }
    </style>
</head>

<body>

    <h2>FORMULIR USULAN DATA TENAGA BARU</h2>
    <p>Berikut adalah data lengkap usulan baru</p>

    <table>
        <tr>
            <th>NIK</th>
            <td><?= esc($pekerja['nik']) ?></td>
        </tr>
        <tr>
            <th>Nama Lengkap</th>
            <td><?= esc($pekerja['nama']) ?></td>
        </tr>
        <tr>
            <th>Tempat, Tanggal Lahir</th>
            <td><?= esc($pekerja['tempat_lahir']) ?>, <?= date('d-m-Y', strtotime($pekerja['tanggal_lahir'])) ?></td>
        </tr>
        <tr>
            <th>Jenis Kelamin</th>
            <td><?= $pekerja['jenis_kelamin'] === 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
        </tr>
        <tr>
            <?php list($rt, $rw) = explode('/', esc($pekerja['rt/rw'])); ?>
            <th>Alamat</th>
            <td><?= esc($pekerja['desa/kelurahan']) ?>, RT <?= esc($rt) ?>, RW <?= esc($rw) ?>, Kec. <?= esc($pekerja['kecamatan']) ?>,
                <?= esc($pekerja['kota_tinggal']) ?></td>
        </tr>
        <tr>
            <th>Pendidikan</th>
            <td><?= esc($pekerja['pendidikan']) ?> - <?= esc($pekerja['jurusan']) ?></td>
        </tr>
        <tr>
            <th>Gelar</th>
            <td><?= esc($pekerja['gelar_depan']) == '-' ? '' : esc($pekerja['gelar_depan']) ?> <?= esc($pekerja['nama']) ?>
                <?= esc($pekerja['gelar_belakang']) == '-' ? '' : ', ' . esc($pekerja['gelar_belakang']) ?></td>
        </tr>
        <tr>
            <th>Pekerjaan</th>
            <td><?= esc($pekerja['pekerjaan']) ?> (<?= esc($pekerja['jenis_pegawai']) ?>)</td>
        </tr>
        <tr>
            <th>Unit Kerja</th>
            <td><?= esc($pekerja['unit_kerja']) ?></td>
        </tr>
        <tr>
            <th>Tahun & TMT/TST</th>
            <td>Tahun: <?= esc($pekerja['tahun']) ?><br>
                TMT: <?= date('d-m-Y', strtotime($pekerja['tmt_kerja'])) ?><br>
                TST: <?= date('d-m-Y', strtotime($pekerja['tst_kerja'])) ?></td>
        </tr>
        <tr>
            <th>Status</th>
            <td>
                <?php
                $sudahPensiun = !empty($pekerja['tanggal_pensiun']) && $pekerja['tanggal_pensiun'] <= date('Y-m-d');
                echo $sudahPensiun ? 'Pensiun' : esc($pekerja['status']);
                ?>
            </td>
        </tr>
    </table>

    <br><br>
    <p style="text-align:right;">
        Dicetak pada: <?= date('d-m-Y') ?>
    </p>
    <br>
    <div style="width: 100%; margin-top: 10px;">
        <div style="width: 300px; text-align: center; float: right;">
            Mengetahui,<br>
            <?= $jabatan ?><br>Kota Pekalongan<br><br><br><br><br>
            <u><b><?= $nama_kepala ?></b></u><br>
            NIP. <?= $nip ?>
        </div>
    </div>
    <!-- ketika terbuka maka otomatis window print -->
    <script>
        window.onload = function() {
            window.print();
            setTimeout(function() {
                window.close();
                // arahkan ke halaman sebelumnya
                window.location.href = document.referrer;
            }, 1000); // menutup jendela setelah 1 detik
        }
    </script>
</body>

</html>