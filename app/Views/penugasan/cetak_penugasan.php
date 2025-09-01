<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Cetak Usulan Penugasan Baru</title>
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

        h2 {
            margin: 0;
            padding: 2px 0;
        }

        .text-center {
            text-align: center;
        }

        @media print {
            @page {
                size: landscape;
            }
        }
    </style>
</head>

<body>

    <h2>DATA PENGAJUAN PENUGASAN BARU</h2>
    <h2>DINAS LINGKUNGAN HIDUP</h2>
    <h2>KOTA PEKALONGAN</h2>

    <table id="tableDataPekerja" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>Nama</th>
                <th>Unit Kerja</th>
                <th>Pekerjaan</th>
                <th>TMT</th>
                <th>TST</th>
                <th>Tahun</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($dataPekerja as $item): ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= esc($item['nama']) ?></td>
                    <td><?= esc($item['unit_kerja'] ? $item['unit_kerja'] : 'Tidak Diketahui') ?></td>
                    <td><?= esc($item['pekerjaan'] ? $item['pekerjaan'] : 'Tidak Diketahui') ?></td>
                    <td><?= $item['tmt_kerja'] ? date('d-m-Y', strtotime($item['tmt_kerja'])) : 'Tidak Diketahui' ?></td>
                    <td><?= $item['tst_kerja'] ? date('d-m-Y', strtotime($item['tst_kerja'])) : 'Tidak Diketahui' ?></td>
                    <td><?= esc($item['tahun']) ?></td>
                    <td><span class="badge bg-warning text-dark rounded"><?= esc(ucfirst($item['status'])) ?></span></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    <p style="text-align:right;">
        Dicetak pada: <?= date('d-m-Y') ?>
    </p>
    <div style="width: 100%; margin-top: 20px;">
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