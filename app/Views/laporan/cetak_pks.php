<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            font-family: 'Bookman Old Style', serif;
            font-size: 13pt;
            margin: 0px;
            line-height: 1.4;
        }

        .judul {
            text-align: center;
            text-transform: uppercase;
        }

        .nomor {
            text-align: center;
            margin-bottom: 30px;
        }

        .isi {
            text-align: justify;
            /* buat spasi menjadi 1.25 */
            line-height: 1.25;
            margin-bottom: 1em;
        }

        .data {
            margin-left: 30px;
        }

        ol {
            padding-left: 0px;
        }

        ul {
            list-style-type: lower-alpha;
            margin-left: 20px;
        }

        .pasal {
            text-align: center;
            margin-top: 20px;
        }

        .lingkup {
            text-align: center;
        }

        .custom-list {
            list-style: none;
            counter-reset: item;
            padding-left: 2em;
        }

        .custom-list>li {
            counter-increment: item;
            position: relative;
            margin-bottom: 1em;
            line-height: 1.2;
        }

        .custom-list>li::before {
            content: counter(item) ") ";
            position: absolute;
            left: -2em;
        }

        .custom-list ul {
            list-style-type: lower-alpha;
            padding-left: 1.2em;
            margin-left: 0;
        }

        .custom-list li {
            line-height: 1.2em;
            margin-bottom: 4px;
        }

        .img {
            width: 100vw;
            height: 100px;
        }

        @media print {
            .page-break {
                page-break-before: always;
            }
        }
    </style>
</head>

<?php
$tanggalsk = date('Y') - 1 . '-12-31';
$harisk = date('D', strtotime($tanggalsk));

function getHariIndo($hariInggris)
{
    $hari = [
        'Sun' => 'Minggu',
        'Mon' => 'Senin',
        'Tue' => 'Selasa',
        'Wed' => 'Rabu',
        'Thu' => 'Kamis',
        'Fri' => 'Jumat',
        'Sat' => 'Sabtu'
    ];
    return $hari[$hariInggris] ?? $hariInggris;
}

function terbilang($angka)
{
    $angka =  abs((float) $angka);
    $huruf = ["", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"];
    $temp = "";

    if ($angka < 12) {
        $temp = $huruf[$angka];
    } elseif ($angka < 20) {
        $temp = $huruf[$angka - 10] . " belas";
    } elseif ($angka < 100) {
        $puluh = floor($angka / 10);
        $sisa = $angka % 10;
        $temp = $huruf[$puluh] . " puluh" . ($sisa ? " " . $huruf[$sisa] : "");
    } elseif ($angka < 200) {
        $temp = "seratus " . terbilang($angka - 100);
    } elseif ($angka < 1000) {
        $ratus = floor($angka / 100);
        $sisa = $angka % 100;
        $temp = $huruf[$ratus] . " ratus" . ($sisa ? " " . terbilang($sisa) : "");
    } elseif ($angka < 2000) {
        $temp = "seribu " . terbilang($angka - 1000);
    } elseif ($angka < 1000000) {
        $ribu = floor($angka / 1000);
        $sisa = $angka % 1000;
        $temp = terbilang($ribu) . " ribu" . ($sisa ? " " . terbilang($sisa) : "");
    } elseif ($angka < 1000000000) {
        $juta = floor($angka / 1000000);
        $sisa = $angka % 1000000;
        $temp = terbilang($juta) . " juta" . ($sisa ? " " . terbilang($sisa) : "");
    }

    return trim($temp);
}

function formatTanggalHuruf($tanggal)
{
    $bulanIndo = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember'
    ];

    $tgl = (int)date('d', strtotime($tanggal));
    $bln = (int)date('m', strtotime($tanggal));
    $thn = (int)date('Y', strtotime($tanggal));

    return terbilang($tgl) . " " . $bulanIndo[$bln] . " " . terbilang($thn);
}
?>

<body>
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
        <div class="<?= $i > 0 ? 'page-break' : '' ?>">
            <img src="<?= base_url('assets/kop/dlh.png') ?>" alt="KOP SK" class="img-fluid mb-4">
            <div class="judul">PERJANJIAN KERJA</div>
            <div class="judul">ANTARA</div>
            <div class="judul">DINAS LINGKUNGAN HIDUP KOTA PEKALONGAN</div>
            <div class="judul">DENGAN</div>
            <div class="judul">PEGAWAI NON PNS</div>

            <div class="nomor">
                Nomor : 800.1.2/ ...........
            </div>
            <ol class="isi">
                <li>
                    Pada hari ini <?= getHariIndo($harisk) ?> tanggal <?= formatTanggalHuruf($tanggalsk) ?> (<?= date('d-m-Y', strtotime($tanggalsk)) ?>)</strong> bertempat di Pekalongan, kami yang bertanda tangan di bawah ini:
                    <?php foreach ($daftarKepala as $kepala): ?>
                        <?php if (esc($kepala['unit_kerja']) == 'Dinas Lingkungan Hidup') : ?>
                            <div class="data">
                                <table>
                                    <tr>
                                        <td style="width: 1px;">1.</td>
                                        <td>Nama</td>
                                        <td>: <?= esc($kepala['nama_kepala']) ?></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>NIP</td>
                                        <td>: <?= esc($kepala['nip']) ?></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>Jabatan</td>
                                        <td>: Pembina Utama Muda</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>Alamat Unit Kerja</td>
                                        <td>: Jalan Tentara Pelajar No.1 Pekalongan</td>
                                    </tr>
                                </table>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </li>
                Bertindak untuk dan atas nama Dinas Lingkungan Hidup Kota Pekalongan, selanjutnya dalam hal ini disebut sebagai PIHAK KESATU

                <li>
                    <div class="data">
                        <table class="mt-1">
                            <tr>
                                <td style="width: 1px;">2.</td>
                                <td style="width: 120px;">Nama</td>
                                <td style="width: 10px;">:</td>
                                <td>
                                    <?= ($pekerja['gelar_depan'] != '-' ? $pekerja['gelar_depan'] . ' ' : '') .
                                        $pekerja['nama'] .
                                        ($pekerja['gelar_belakang'] != '-' ? ', ' . $pekerja['gelar_belakang'] : '') ?>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>NIK</td>
                                <td>:</td>
                                <td><?= esc($pekerja['nik']) ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td style="white-space: nowrap;">Tempat, Tgl. Lahir</td>
                                <td>:</td>
                                <td><?= esc($pekerja['tempat_lahir']) ?>, <?= formatTanggalIndo($pekerja['tanggal_lahir']) ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Jenis Pegawai</td>
                                <td>:</td>
                                <td><?= esc($pekerja['jenis_pegawai'] == 'Kontrak Dinas' ? 'Tenaga Kegiatan' : $pekerja['jenis_pegawai']) ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Jenis Penugasan</td>
                                <td>:</td>
                                <td><?= esc($pekerja['pekerjaan']) ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Pendidikan</td>
                                <td>:</td>
                                <td><?= esc($pekerja['pendidikan']) ?> <?= esc($pekerja['jurusan'] != '-' ? '(' . $pekerja['jurusan'] . ')' : '') ?></td>
                            </tr>
                            <?php
                            $rt_rw = explode('/', $pekerja['rt/rw']);
                            $rt = $rt_rw[0] ?? '';
                            $rw = $rt_rw[1] ?? '';
                            ?>
                            <tr>
                                <td></td>
                                <td style="vertical-align: top;">Alamat Rumah</td>
                                <td style="vertical-align: top;">:</td>
                                <td style="text-align: justify;">
                                    <?= esc($pekerja['desa/kelurahan']) ?>, RT <?= esc($rt) ?> RW <?= esc($rw) ?>,
                                    Kec. <?= esc($pekerja['kecamatan']) ?>, <?= esc($pekerja['kota_tinggal']) ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="isi">
                        Bertindak untuk dan atas namanya sendiri, selanjutnya dalam hal ini disebut sebagai PIHAK KEDUA.<br>
                        Maka dengan ini PIHAK KESATU dan PIHAK KEDUA secara bersama-sama saling setuju dan sepakat untuk mengadakan Perjanjian Kerja dengan ketentuan sebagai berikut:
                    </div>
                </li>
            </ol>

            <div class="pasal">Pasal 1</div>
            <div class="lingkup">LINGKUP PEKERJAAN</div>

            <div class="isi">
                <ol class="custom-list">
                    <li>
                        PIHAK KESATU memberi tugas/pekerjaan kepada PIHAK KEDUA dan PIHAK KEDUA setuju untuk menerima pekerjaan dari PIHAK KESATU sebagai Pegawai Non PNS di Dinas Lingkungan Hidup Pemerintah Kota Pekalongan dengan lingkup pekerjaan sebagai berikut:
                        <ul>
                            <?php
                            $uraians = explode(';', $pekerja['uraian_pekerjaan']);
                            foreach ($uraians as $uraian) :
                                $uraian = trim($uraian); // Hapus spasi ekstra
                                if ($uraian !== ''): ?>
                                    <li><?= esc($uraian) ?>;</li>
                            <?php endif;
                            endforeach; ?>
                        </ul>
                    </li>
                    <li>
                        Dalam melaksanakan pekerjaan tersebut dalam ayat (1), maka PIHAK KEDUA harus tunduk pada tata tertib serta perintah langsung atau tidak langsung dari PIHAK KESATU atau <?= strtoupper($pekerja['jabatan_short']) ?> sesuai dengan jenjang jabatan yang berlaku di Dinas Lingkungan Hidup Kota Pekalongan.
                    </li>
                </ol>
            </div>

            <div class="pasal">Pasal 2</div>
            <div class="lingkup">PENUGASAN DAN PENEMPATAN</div>

            <div class="isi">
                <ol class="custom-list">
                    <li>PIHAK KESATU sebagai pimpinan unit kerja yang mengarahkan, membina, membimbing, dan mengawasi PIHAK KEDUA dalam melaksanakan penugasan sebagai <?= $pekerja['pekerjaan'] ?>.</li>
                    <li>PIHAK KESATU dapat mendelegasikan tugasnya sebagaimana dimaksud dalam ayat 1) kepada <?= strtoupper($pekerja['jabatan_short']) ?> yang mempunyai tanggung jawab sebagai ATASAN LANGSUNG PIHAK KEDUA.</li>
                    <li>PIHAK KESATU dapat menugaskan PIHAK KEDUA untuk ditempatkan di seluruh lingkungan Dinas Lingkungan Hidup Kota Pekalongan.</li>
                </ol>
            </div>

            <div class="pasal">Pasal 3</div>
            <div class="lingkup">HARI KERJA DAN WAKTU KERJA</div>

            <div class="isi">
                <ol class="custom-list">
                    <li>Hari kerja dan jam kerja untuk PIHAK KEDUA sesuai dengan ketentuan yang berlaku pada Instansi yang dipimpin PIHAK KESATU;</li>
                    <li>Jam Kerja di hari libur (minggu/tanggal merah) yang ditentukan oleh PIHAK KESATU sesuai dengan kebutuhan, wajib dipatuhi oleh PIHAK KEDUA.</li>
                    <li>
                        PIHAK KEDUA diberikan ijin untuk tidak masuk kerja, apabila:
                        <ul>
                            <li> berhalangan dan atau sakit paling lama 2 hari. Sakit lebih dari 2 hari dibuktikan dengan surat keterangan dokter</li>
                            <li> istirahat karena melahirkan, dapat diberikan sampai dengan kelahiran anak yang kedua</li>
                            <li> karena alasan penting kematian istri/suami/anak/orang tua</li>
                            <li> karena alasan penting menunaikan ibadah umrah/haji</li>
                            <li> karena alasan penting melangsungkan pernikahan</li>
                        </ul>
                    </li>
                    <li>Pengajuan ijin tidak masuk kerja sebagaimana dimaksud dalam pasal (3) harus dengan ijin tertulis kepada PIHAK KESATU</li>
                    <li>Pemberian ijin tidak masuk kerja dan jangka waktu ijin tidak masuk kerja diputuskan oleh PIHAK KESATU</li>
                </ol>
            </div>

            <div class="pasal">Pasal 4</div>
            <div class="lingkup">HAK DAN KEWAJIBAN</div>

            <div class="isi">
                <ol class="custom-list">
                    <li>
                        Selama hubungan kerja berlangsung, PIHAK KEDUA mempunyai hak sebagai berikut:
                        <ul>
                            <li> PIHAK KEDUA berhak menerima upah dari PIHAK KESATU;</li>
                            <li> Upah dibayarkan secara bulanan kepada PIHAK KEDUA setiap akhir bulan berjalan; dan</li>
                            <li> Hak lainnya dapat diberikan sesuai dengan ketentuan pengelolaan keuangan daerah Kota Pekalongan</li>
                        </ul>
                    </li>
                    <li>
                        Selama hubungan kerja berlangsung, PIHAK KEDUA berkewajiban sebagai berikut:
                        <ul>
                            <li> Mentaati tata tertib kerja dan peraturan yang berlaku pada Dinas Lingkungan Hidup Kota Pekalongan</li>
                            <li> Hadir tepat waktu sesuai ketentuan Pasal 3, dan wajib menggunakan absensi pindai wajah, dikecualikan bagi jenis penugasan tertentu yang ditetapkan PIHAK KESATU;</li>
                            <li> Berpakaian rapi dan sopan;</li>
                            <li> Melaksanakan tugas dengan sebaik-baiknya;</li>
                            <li> Berkoordinasi dan bekerjasama dengan sesama Pegawai Non PNS dan PNS;</li>
                            <li> Merawat serta menjaga aset peralatan kerja dan bahan kerja;</li>
                            <li> PIHAK KEDUA tidak menuntut untuk diangkat menjadi CPNS, PNS ataupun PPPK di lingkungan Pemerintah Kota Pekalongan;</li>
                        </ul>
                    </li>
                    <li>Selama hubungan kerja berlangsung, PIHAK KESATU mempunyai hak sebagai berikut :
                        <ul>
                            <li> Menetapkan tugas, pokok, dan fungsi PIHAK KEDUA;</li>
                            <li> Mengevaluasi dan mengawasi kinerja dan etika PIHAK KEDUA;</li>
                            <li> Memperoleh kinerja yang maksimal dari PIHAK KEDUA.</li>
                        </ul>
                    </li>
                </ol>
            </div>

            <div class="pasal">Pasal 5</div>
            <div class="lingkup">JANGKA WAKTU DAN PEMBAYARAN</div>

            <div class="isi">
                <ol class="custom-list">
                    <li>Perjanjian Kerja ini berlaku untuk jangka waktu <?= $pekerja['bulan_kerja'] ?> bulan terhitung mulai tanggal <?= formatTanggalIndo($pekerja['tmt_kerja']) ?> sampai dengan <?= formatTanggalIndo($pekerja['tst_kerja']) ?>.</li>
                    <li>Pembayaran upah sebesar Rp. <?= number_format((float) str_replace(['Rp', '.', ','], '', $pekerja['gaji']), 0, ',', '.') ?>,- (<?= terbilang($pekerja['gaji']) . ' ' . 'Rupiah' ?>) /bulan</li>
                    <li>Pembayaran dilakukan secara bulanan melalui Bank Pekalongan dengan mekanisme transfer ke rekening PIHAK KEDUA</li>
                </ol>
                <p>
                    Perjanjian Kerja sebagaimana dimaksud ayat (1) dapat diperpanjang atas kesepakatan kedua belah pihak dengan memperhatikan hasil evaluasi kinerja, kebutuhan tenaga dan ketersediaan anggaran.
                </p>
            </div>

            <div class="pasal">Pasal 6</div>
            <div class="lingkup">SANKSI</div>

            <div class="isi">
                <ol class="custom-list">
                    <li>Sanksi diberikan apabila melakukan tindakan pelanggaran kedisiplinan dan pelanggaran berupa:
                        <ul>
                            <li> Melanggar/tidak mentaati tata tertib kerja dan peraturan yang berlaku pada Dinas Lingkungan Hidup Kota Pekalongan;</li>
                            <li> Tidak ada perbaikan kinerja setelah mendapat 2 kali surat teguran tertulis atas dasar hasil evaluasi kinerja yang dilakukan oleh PIHAK KESATU;</li>
                            <li> Tidak hadir selama 5 (lima) hari kerja atau lebih dalam satu bulan tanpa alasan dan tidak dilengkapi dengan bukti yang sah;</li>
                            <li> Bekerja rangkap di instansi lain pada jam kerja yang disepakati;</li>
                            <li> Melimpahkan pekerjaannya kepada pihak lain tanpa sepengetahuan PIHAK KESATU.</li>
                            <li> Melakukan pencurian, penggelapan, perusakan dan atau perbuatan melawan hukum lainnya.</li>
                            <li> Melakukan penganiayaan atau berkelahi dengan rekan kerja</li>
                            <li> Mabuk, berjudi, menggunakan obat terlarang di lingkungan kerja.</li>
                            <li> Mencemarkan nama baik pimpinan, teman kerja dan/atau tempat kerja;</li>
                            <li> Menggunakan dan atau memanfaatkan fasilitas untuk usaha lain (kepentingan pribadi) baik di dalam maupun di luar jam kerja tanpa izin yang sah;</li>
                            <li> Membocorkan rahasia jabatan dan dokumen negara;</li>
                            <li> Dinyatakan bersalah berdasarkan keputusan pengadilan yang telah berkekuatan hukum tetap;</li>
                            <li> Merusak dengan sengaja dan/atau menghilangkan asset baik secara keseluruhan dan/atau sebagian asset milik Pemerintah Kota Pekalongan;</li>
                        </ul>
                    </li>
                    <li>Jika PIHAK KEDUA melanggar Pasal 6 ayat (1), maka PIHAK KESATU berhak memutuskan hubungan kerja secara sepihak tanpa syarat.</li>
                </ol>
            </div>

            <div class="pasal">Pasal 7</div>
            <div class="lingkup">PEMUTUSAN HUBUNGAN KERJA</div>

            <div class="isi">
                <ol class="custom-list">
                    <li>PIHAK KESATU dapat mengakhiri hubungan kerja dengan PIHAK KEDUA apabila:
                        <ul>
                            <li> PIHAK KEDUA meninggal dunia;</li>
                            <li> Batas waktu Perjanjian Kerja berakhir;</li>
                            <li> PIHAK KEDUA mengundurkan diri;</li>
                            <li> PIHAK KEDUA memasuki batas usia pensiun, maksimal 58 tahun;</li>
                            <li> PIHAK KEDUA melanggar peraturan sebagaimana dimaksud dalam Pasal 6 ayat (1);</li>
                        </ul>
                    </li>
                    <li>Akibat berakhirnya atau putusnya Perjanjian/Kontrak Kerja ini, maka PIHAK KEDUA atau ahli waris PIHAK KEDUA tidak berhak menuntut PIHAK KESATU atas ganti rugi kecuali sisa penghasilan yang belum dibayarkan.</li>
                </ol>
            </div>

            <div class="pasal">Pasal 8</div>
            <div class="lingkup">PERSELISIHAN</div>

            <div class="isi">
                <ol class="custom-list">
                    <li>Apabila terjadi perselisihan antara PIHAK KESATU dan PIHAK KEDUA dalam pelaksanaan Perjanjian Kerja ini akan diselesaikan secara musyawarah dan mufakat.</li>
                    <li>Apabila tidak tercapai musyawarah dan mufakat sebagaimana dimaksud ayat (1) akan diselesaikan melalui peradilan di wilayah hukum Kota Pekalongan.</li>
                </ol>
            </div>

            <div class="pasal">Pasal 9</div>
            <div class="lingkup">KETENTUAN PENUTUP</div>

            <div class="isi">
                <ol class="custom-list">
                    <li>Hal-hal yang belum diatur dalam Perjanjian Kerja ini akan ditetapkan kemudian oleh kedua belah pihak dalam perjanjian tambahan yang merupakan bagian yang tidak terpisahkan dari dokumen ini.</li>
                    <li>Perjanjian ini dibuat dan ditandatangani oleh kedua belah pihak, dibuat rangkap 3 (tiga), rangkap asli bermaterai cukup dan rangkap lainnya sebagai tembusan.</li>
                    <li>Segala lampiran yang melengkapi Perjanjian Kerja ini merupakan bagian tidak terpisahkan dan mempunyai kekuatan hukum yang sama.</li>
                </ol>
            </div>

            <p>Demikian Perjanjian Kerja Waktu Tertentu ini dibuat oleh PIHAK KESATU dan PIHAK KEDUA dalam keadaan sadar tanpa ada paksaan dari pihak manapun.</p>

            <table style="width:100%; margin-top: 0px;">
                <tr>
                    <td style="text-align:center; width: 50%;">
                        PIHAK KEDUA<br><br><br><br>
                        <?=
                        ($pekerja['gelar_depan'] != '-' ? $pekerja['gelar_depan'] . ' ' : '') .
                            $pekerja['nama'] .
                            ($pekerja['gelar_belakang'] != '-' ? ', ' . $pekerja['gelar_belakang'] : '')
                        ?><br>
                        &nbsp;
                    </td>
                    <?php foreach ($daftarKepala as $kepala): ?>
                        <?php if (esc($kepala['unit_kerja']) == 'Dinas Lingkungan Hidup') : ?>
                            <td style="text-align:center;width: 50%;">
                                PIHAK KESATU<br><br><br><br>
                                <u><?= esc($kepala['nama_kepala']) ?></u><br>
                                NIP. <?= esc($kepala['nip']) ?><br>
                            </td>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tr>
            </table>
        </div>
    <?php $i++;
    endforeach; ?>

    <script>
        window.print();
        setTimeout(function() {
            window.close();
            window.location.href = '<?= site_url('laporan') ?>';
        }, 1000);
    </script>


</body>

</html>