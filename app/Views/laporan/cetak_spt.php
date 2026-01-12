<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Perintah Tugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        * {
            font-family: 'Bookman Old Style', serif;
        }

        .table-dasar {
            width: 100%;
            border-collapse: collapse;
            font-size: 12pt;
            line-height: 1.5;
        }

        .table-dasar td {
            vertical-align: top;
            padding: 3px;
        }

        .table-dasar .label {
            width: 100px;
            font-weight: bold;
            white-space: nowrap;
        }

        .table-dasar .colon {
            width: 10px;
        }

        .table-dasar td ol,
        .table-dasar td p {
            text-align: justify;
        }


        @media print {
            .page-break {
                page-break-before: always;
            }
        }
    </style>
</head>

<?php $i = 0;
function formatTanggalIndo($tanggal)
{
    $bulanIndo = [
        1 => 'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    ];

    $tgl = date('d', strtotime($tanggal));
    $bln = (int)date('m', strtotime($tanggal));
    $thn = date('Y', strtotime($tanggal));

    return $tgl . ' ' . $bulanIndo[$bln] . ' ' . $thn;
};
foreach ($daftarPekerja as $pekerja) : ?>

    <body>
        <div class="<?= $i > 0 ? 'page-break' : '' ?>">
            <img src="<?= base_url('assets/kop/dlh.png') ?>" alt="KOP SK" class="img-fluid">

            <h5 class="text-center mt-3 m-0"><u>SURAT PERINTAH TUGAS</u></h5>
            <div class="text-center mb-3">
                Nomor: 800.1.2/ .............
            </div>

            <div class="row">
                <table class="table-dasar">
                    <tr>
                        <td class="label">
                            <p class="ms-3">Dasar</p>
                        </td>
                        <td class="colon">:</td>
                        <td>
                            <ol style="margin: 0; padding-left: 18px; margin-right: 15px;">
                                <?php foreach ($dasarHukum as $item): ?>
                                    <li><?= esc($item['nama_dasar_hukum']) ?> Nomor <?= esc($item['nomor']) ?> Tahun <?= esc($item['tahun']) ?> Tentang <?= esc($item['tentang']) ?></li>
                                <?php endforeach; ?>
                                <li>Surat Perjanjian Kerja Nomor: 800.1.2/ ................ Tanggal 31 Desember <?= date('Y') - 1 ?> Tentang Perjanjian kerja Antara Dinas Lingkungan Hidup Kota Pekalongan dengan sdr. <?=
                                                                                                                                                                                                                        ($pekerja['gelar_depan'] != '-' ? $pekerja['gelar_depan'] . ' ' : '') .
                                                                                                                                                                                                                            $pekerja['nama'] .
                                                                                                                                                                                                                            ($pekerja['gelar_belakang'] != '-' ? ', ' . $pekerja['gelar_belakang'] : '')
                                                                                                                                                                                                                        ?></li>
                            </ol>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="row">
                <div class="text-center mb-2 mt-2">
                    <h5 class="fw-bold">MEMERINTAHKAN</h5>
                </div>

                <div class="row mb-3">
                    <div class="col-1 fw-bold ms-1 me-4">Kepada</div>
                    <div class="col-1 w-auto">:</div>
                    <div class="col">
                        <div class="row mb-1">
                            <div class="col-4">Nama</div>
                            <div class="col-1 w-auto">:</div>
                            <div class="col">
                                <?=
                                ($pekerja['gelar_depan'] != '-' ? $pekerja['gelar_depan'] . ' ' : '') .
                                    $pekerja['nama'] .
                                    ($pekerja['gelar_belakang'] != '-' ? ', ' . $pekerja['gelar_belakang'] : '')
                                ?>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-4">NIK</div>
                            <div class="col-1 w-auto">:</div>
                            <div class="col"><?= esc($pekerja['nik']) ?></div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-4">Tempat/Tanggal Lahir</div>
                            <div class="col-1 w-auto">:</div>
                            <div class="col">
                                <?= $pekerja['tempat_lahir'] . ', ' . formatTanggalIndo($pekerja['tanggal_lahir']) ?>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-4">Pendidikan</div>
                            <div class="col-1 w-auto">:</div>
                            <div class="col">
                                <?= $pekerja['pendidikan'] . ' ' . esc($pekerja['jurusan'] != '-' ? $pekerja['jurusan'] : '') ?>
                            </div>
                        </div>
                        <?php
                        $rt_rw = explode('/', $pekerja['rt/rw']);
                        $rt = $rt_rw[0] ?? '';
                        $rw = $rt_rw[1] ?? '';
                        ?>
                        <div class="row">
                            <div class="col-4">Alamat</div>
                            <div class="col-1 w-auto">:</div>
                            <div class="col">
                                <?= esc($pekerja['desa/kelurahan']) ?>, RT <?= esc($rt) ?> RW <?= esc($rw) ?>, Kec. <?= esc($pekerja['kecamatan']) ?>, <?= esc($pekerja['kota_tinggal']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            if (!function_exists('terbilang')) {
                function terbilang($angka)
                {
                    $angka = abs((float) $angka);
                    $huruf = [
                        '',
                        'Satu',
                        'Dua',
                        'Tiga',
                        'Empat',
                        'Lima',
                        'Enam',
                        'Tujuh',
                        'Delapan',
                        'Sembilan',
                        'Sepuluh',
                        'Sebelas'
                    ];
                    $temp = '';
                    if ($angka < 12) {
                        $temp = ' ' . $huruf[$angka];
                    } elseif ($angka < 20) {
                        $temp = terbilang($angka - 10) . ' Belas ';
                    } elseif ($angka < 100) {
                        $temp = terbilang(floor($angka / 10)) . ' Puluh ' . terbilang($angka % 10);
                    } elseif ($angka < 200) {
                        $temp = ' Seratus' . terbilang($angka - 100);
                    } elseif ($angka < 1000) {
                        $temp = terbilang(floor($angka / 100)) . ' Ratus ' . terbilang($angka % 100);
                    } elseif ($angka < 2000) {
                        $temp = ' Seribu' . terbilang($angka - 1000);
                    } elseif ($angka < 1000000) {
                        $temp = terbilang(floor($angka / 1000)) . ' Ribu ' . terbilang($angka % 1000);
                    } elseif ($angka < 1000000000) {
                        $temp = terbilang(floor($angka / 1000000)) . ' Juta ' . terbilang($angka % 1000000);
                    }

                    return trim($temp);
                }
            }
            ?>

            <div class="row">
                <table class="table-dasar">
                    <tr>
                        <td class="label">
                            <p class="ms-3">Untuk</p>
                        </td>
                        <td class="colon">:</td>
                        <td>
                            <ol style="margin: 0; padding-left: 18px; margin-right: 15px;">
                                <li class="me-3">Melaksanakan tugas sebagai <?= esc($pekerja['pekerjaan']) ?> Pada <?= esc($pekerja['detail']) ?> dengan diberi Upah Rp. <?= number_format((float) str_replace(['Rp', '.', ','], '', $pekerja['gaji']), 0, ',', '.') ?>,- (<?= terbilang($pekerja['gaji']) . ' ' . 'Rupiah' ?>), terhitung mulai tanggal <?= formatTanggalIndo($pekerja['tmt_kerja']) ?> s/d <?= formatTanggalIndo($pekerja['tst_kerja']) ?>.</li>
                                <li>Melaporkan hasil pelaksanaan tugas kepada pejabat pemberi tugas, melalui Atasan langsung sesuai bidang tugasnya.</li>
                            </ol>
                        </td>
                    </tr>
                </table>
            </div>

            <p class="mt-2 ms-2" style="text-align: justify;">
                Apabila terdapat kekeliruan dalam surat perintah tugas ini akan diadakan perbaikan sebagaimana mestinya.
                <br>Demikian untuk menjadi pedoman dan dilaksanakan dengan penuh rasa tanggung jawab.
            </p>
            <?php foreach ($daftarKepala as $kepala): ?>
                <?php if (esc($kepala['unit_kerja']) == 'Dinas Lingkungan Hidup') : ?>
                    <div class="w-100 mt-1">
                        <div class="d-flex justify-content-end">
                            <div style="width: 400px;">
                                <p class="mb-0 ms-5">Ditetapkan di Pekalongan</p>
                                <p class="mb-2 ms-5">Pada Tanggal : 31 Desember <?= date('Y') - 1 ?></p>
                                <!-- <hr class="mt-0 mb-2 ms-5" style="border-top: 2px solid black;"> -->
                                <div class="text-center">
                                    <strong>KEPALA DINAS LINGKUNGAN HIDUP<br>
                                        KOTA PEKALONGAN</strong>
                                    <br><br><br>
                                    <div class="fw-bold"><u><?= esc($kepala['nama_kepala']) ?></u></div>
                                    <div>Pembina Utama Muda</div>
                                    <div>NIP. <?= esc($kepala['nip']) ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>

        <?php $i++;
    endforeach; ?>

        <script>
            window.onload = function() {
                window.print();
                setTimeout(function() {
                    window.close();
                    // arahkan ke halaman utama setelah cetak
                    window.location.href = '<?= site_url('laporan') ?>';
                }, 1000);
            };
        </script>

    </body>

</html>