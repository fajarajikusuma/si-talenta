<?php

use CodeIgniter\Database\BaseBuilder;

function db()
{
    return \Config\Database::connect();
}

function countGenderActive($gender)
{
    $unit_kerja_nama = strtolower(session()->get('unitKerja'));
    $id_unit_kerja = session()->get('id_unit_kerja');

    $builder = db()->table('tb_data_pekerja');
    $builder->join('tb_riwayat_pekerjaan', 'tb_data_pekerja.id_pekerja = tb_riwayat_pekerjaan.id_pekerja');

    $builder->where('tb_data_pekerja.status_pekerja', 'Terverifikasi');
    $builder->where('tb_data_pekerja.deleted_at', null);
    $builder->where('tb_data_pekerja.jenis_kelamin', $gender);
    $builder->where('tb_riwayat_pekerjaan.status', 'Terverifikasi');

    // Tambahkan filter berdasarkan unit kerja hanya jika bukan DLH
    if ($unit_kerja_nama != 'dinas lingkungan hidup') {
        $builder->where('tb_riwayat_pekerjaan.id_unit_kerja', $id_unit_kerja);
    }

    return $builder->countAllResults();
}

function ageRangeActive()
{
    $unit_kerja_nama = strtolower(session()->get('unitKerja'));
    $id_unit_kerja = session()->get('id_unit_kerja');
    $builder = db()->table('tb_data_pekerja');
    $builder->join('tb_riwayat_pekerjaan', 'tb_data_pekerja.id_pekerja = tb_riwayat_pekerjaan.id_pekerja');
    $builder->select('YEAR(CURDATE()) - YEAR(tb_data_pekerja.tanggal_lahir) AS age');
    $builder->where('tb_data_pekerja.status_pekerja', 'Terverifikasi');
    $builder->where('tb_data_pekerja.deleted_at', null);
    $builder->where('tb_riwayat_pekerjaan.status', 'Terverifikasi');

    // Tambahkan filter berdasarkan unit kerja hanya jika bukan DLH
    if ($unit_kerja_nama != 'dinas lingkungan hidup') {
        $builder->where('tb_riwayat_pekerjaan.id_unit_kerja', $id_unit_kerja);
    }
    $result = $builder->get()->getResultArray();

    if (empty($result)) {
        return [
            '18-25' => 0,
            '26-35' => 0,
            '36-45' => 0,
            '46-55' => 0,
            '56-60' => 0,
            'total' => 0
        ];
    }

    $ages = array_column($result, 'age');

    $rangeCounts = [
        '18-25' => 0,
        '26-35' => 0,
        '36-45' => 0,
        '46-55' => 0,
        '56-60' => 0
    ];

    foreach ($ages as $age) {
        if ($age >= 18 && $age <= 25) {
            $rangeCounts['18-25']++;
        } elseif ($age >= 26 && $age <= 35) {
            $rangeCounts['26-35']++;
        } elseif ($age >= 36 && $age <= 45) {
            $rangeCounts['36-45']++;
        } elseif ($age >= 46 && $age <= 55) {
            $rangeCounts['46-55']++;
        } elseif ($age >= 56 && $age <= 60) {
            $rangeCounts['56-60']++;
        }
    }

    $rangeCounts['total'] = count($ages);
    return $rangeCounts;
}


function countTingkatPendidikan()
{
    //    pecah berdasarkan jenjang pendidikan dari field pendidikan dari sd sampai dengan s3
    // $builder = db()->table('tb_data_pekerja');
    // $builder->select('COUNT(*) as total, pendidikan');
    // $builder->where('status_pekerja', 'Terverifikasi');
    // $builder->where('deleted_at', null);
    // $builder->groupBy('pendidikan');
    // $rows = $builder->get()->getResultArray();

    // $data = [];
    // foreach ($rows as $row) {
    //     $data[$row['pendidikan']] = $row['total'];
    // }
    // // sajikan dalam string masing-masing jenjang pendidikan
    // $result = '';
    // foreach ($data as $pendidikan => $total) {
    //     $result .= ucfirst(strtolower($pendidikan)) . ': ' . $total . '<br>';
    // }
    // // sebelum di sajikan ubah huruf menjadi huruf besar
    // $result = strtoupper($result);
    // return $result;
    $unit_kerja_nama = strtolower(session()->get('unitKerja'));
    $id_unit_kerja = session()->get('id_unit_kerja');

    $builder = db()->table('tb_data_pekerja');
    $builder->select('tb_data_pekerja.pendidikan');
    $builder->join('tb_riwayat_pekerjaan', 'tb_data_pekerja.id_pekerja = tb_riwayat_pekerjaan.id_pekerja');

    $builder->where('tb_data_pekerja.status_pekerja', 'Terverifikasi');
    $builder->where('tb_data_pekerja.deleted_at', null);
    $builder->where('tb_riwayat_pekerjaan.status', 'Terverifikasi');

    if ($unit_kerja_nama != 'dinas lingkungan hidup') {
        $builder->where('tb_riwayat_pekerjaan.id_unit_kerja', $id_unit_kerja);
    }

    $builder->groupBy('tb_data_pekerja.pendidikan');
    $rows = $builder->get()->getResultArray();


    return count($rows) . ' Jenjang Pendidikan';
}

function countUnitBidang()
{
    return db()->table('tb_unit_kerja')->where('unit_kerja !=', 'Dinas Lingkungan Hidup')
        ->countAllResults();
}

function countStatusKontrak()
{
    $builder = db()->table('tb_data_pekerja');
    $builder->select("status_kontrak, COUNT(*) as total");
    $builder->where('status_pekerja', 'Terverifikasi');
    $builder->where('deleted_at', null);
    $builder->groupBy('status_kontrak');
    $rows = $builder->get()->getResultArray();

    $data = ['Aktif' => 0, 'Non-Aktif' => 0];
    foreach ($rows as $row) {
        $status = ucfirst(strtolower($row['status_kontrak']));
        if (isset($data[$status])) {
            $data[$status] = $row['total'];
        }
    }
    return $data;
}

function countPensiun($tahun)
{
    return db()->table('tb_data_pekerja')
        ->where('YEAR(tanggal_pensiun)', $tahun)
        ->where('status_pekerja', 'Terverifikasi')
        ->where('deleted_at', null)
        ->countAllResults();
}

function countJenisTugas()
{
    return db()->table('tb_list_pekerjaan')
        ->where('deleted_at', null)
        ->countAllResults();
}

function countBelumLengkapDokumen()
{
    return db()->table('tb_data_pekerja')
        ->where('status_berkas', 'Belum Lengkap')
        ->where('status_pekerja', 'Terverifikasi')
        ->where('deleted_at', null)
        ->countAllResults();
}

function countUser()
{
    return db()->table('users')
        ->where('deleted_at', null)
        ->countAllResults();
}

function sumGajiBulanIni()
{
    $bulan = date('m');
    $tahun = date('Y');

    return db()->table('tb_riwayat_pekerjaan')
        ->selectSum('gaji')
        ->where('MONTH(created_at)', $bulan)
        ->where('YEAR(created_at)', $tahun)
        ->where('deleted_at', null)
        ->get()->getRow('gaji') ?? 0;
}

function getTingkatPendidikanArray()
{
    $unit_kerja_nama = strtolower(session()->get('unitKerja'));
    $id_unit_kerja = session()->get('id_unit_kerja');

    $builder = db()->table('tb_data_pekerja');
    $builder->select('COUNT(*) as total, tb_data_pekerja.pendidikan');
    $builder->join('tb_riwayat_pekerjaan', 'tb_data_pekerja.id_pekerja = tb_riwayat_pekerjaan.id_pekerja');
    $builder->where('tb_data_pekerja.status_pekerja', 'Terverifikasi');
    $builder->where('tb_data_pekerja.deleted_at', null);
    $builder->where('tb_riwayat_pekerjaan.status', 'Terverifikasi');

    if ($unit_kerja_nama != 'dinas lingkungan hidup') {
        $builder->where('tb_riwayat_pekerjaan.id_unit_kerja', $id_unit_kerja);
    }

    $builder->groupBy('tb_data_pekerja.pendidikan');
    $rows = $builder->get()->getResultArray();

    $data = [];
    foreach ($rows as $row) {
        $data[ucfirst(strtolower($row['pendidikan']))] = (int) $row['total'];
    }

    return $data;
}

function getUnitKerjaWithJumlahPegawai()
{
    $db = db();
    $unit_kerja_nama = strtolower(session()->get('unitKerja'));
    $id_unit_kerja = session()->get('id_unit_kerja');

    // Subquery: ID riwayat terakhir
    $sub = $db->table('tb_riwayat_pekerjaan')
        ->select('MAX(id) as id')
        ->groupBy('id_pekerja');

    $builder = $db->table('tb_riwayat_pekerjaan r');
    $builder->select('u.unit_kerja, COUNT(*) as total');
    $builder->join('tb_data_pekerja d', 'r.id_pekerja = d.id_pekerja');
    $builder->join('tb_unit_kerja u', 'r.id_unit_kerja = u.id_unit_kerja');
    $builder->where('r.status', 'Terverifikasi');
    $builder->where('d.status_pekerja', 'Terverifikasi');
    $builder->where('r.deleted_at', null);
    $builder->where('d.deleted_at', null);
    $builder->whereIn('r.id', $sub);

    if ($unit_kerja_nama != 'dinas lingkungan hidup') {
        $builder->where('r.id_unit_kerja', $id_unit_kerja);
    }

    $builder->groupBy('u.unit_kerja');
    $rows = $builder->get()->getResultArray();

    $data = [];
    foreach ($rows as $row) {
        $data[$row['unit_kerja']] = (int) $row['total'];
    }

    return $data;
}

function countTingkatPendidikanRaw()
{
    $unit_kerja_nama = strtolower(session()->get('unitKerja'));
    $id_unit_kerja = session()->get('id_unit_kerja');

    $builder = db()->table('tb_data_pekerja');
    $builder->select('COUNT(*) as total, tb_data_pekerja.pendidikan');
    $builder->join('tb_riwayat_pekerjaan', 'tb_data_pekerja.id_pekerja = tb_riwayat_pekerjaan.id_pekerja');
    $builder->where('tb_data_pekerja.status_pekerja', 'Terverifikasi');
    $builder->where('tb_data_pekerja.deleted_at', null);
    $builder->where('tb_riwayat_pekerjaan.status', 'Terverifikasi');

    if ($unit_kerja_nama != 'dinas lingkungan hidup') {
        $builder->where('tb_riwayat_pekerjaan.id_unit_kerja', $id_unit_kerja);
    }

    $builder->groupBy('tb_data_pekerja.pendidikan');
    $rows = $builder->get()->getResultArray();

    $data = [];
    foreach ($rows as $row) {
        $data[$row['pendidikan']] = (int) $row['total'];
    }

    return $data;
}
