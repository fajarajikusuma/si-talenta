<?php

/**
 * Helper untuk menampilkan statistik data persebaran pegawai di landing page
 * Kategori: Umur, Jenis Kelamin, dan Pendidikan per Bidang
 */

if (!function_exists('getStatistikGlobal')) {
    /**
     * Mendapatkan statistik global pegawai
     * 
     * @return array
     */
    function getStatistikGlobal()
    {
        $db = \Config\Database::connect();

        // Total pekerja aktif (terverifikasi dan belum pensiun)
        $aktif = $db->table('tb_data_pekerja')
            ->where('deleted_at', null)
            ->where('status_pekerja', 'Terverifikasi')
            ->where('DATE_ADD(tanggal_lahir, INTERVAL 58 YEAR) >= NOW()', null, false)
            ->countAllResults();

        // Total pekerja pensiun
        $pensiun = $db->table('tb_data_pekerja')
            ->where('deleted_at', null)
            ->where('status_pekerja', 'Pensiun')
            ->countAllResults();

        // Total pekerja tidak aktif
        $tidakAktif = $db->table('tb_data_pekerja')
            ->where('deleted_at', null)
            ->where('status_pekerja', 'Tidak Aktif')
            ->countAllResults();

        // Total semua pekerja
        $total = $aktif + $pensiun + $tidakAktif;

        return [
            'aktif' => $aktif,
            'pensiun' => $pensiun,
            'tidak_aktif' => $tidakAktif,
            'total' => $total,
        ];
    }
}

if (!function_exists('getStatistikUmur')) {
    /**
     * Mendapatkan statistik pegawai berdasarkan rentang umur
     * 
     * @return array
     */
    function getStatistikUmur()
    {
        $db = \Config\Database::connect();

        $query = $db->query("
            SELECT 
                CASE 
                    WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 20 AND 30 THEN '20-30 Tahun'
                    WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 31 AND 40 THEN '31-40 Tahun'
                    WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 41 AND 50 THEN '41-50 Tahun'
                    WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 51 AND 58 THEN '51-58 Tahun'
                    ELSE '> 58 Tahun'
                END AS rentang_umur,
                COUNT(*) AS jumlah
            FROM tb_data_pekerja
            WHERE deleted_at IS NULL
            AND status_pekerja IN ('Terverifikasi', 'Pensiun', 'Tidak Aktif')
            GROUP BY rentang_umur
            ORDER BY rentang_umur
        ");

        return $query->getResultArray();
    }
}

if (!function_exists('getStatistikJenisKelamin')) {
    /**
     * Mendapatkan statistik pegawai berdasarkan jenis kelamin
     * 
     * @return array
     */
    function getStatistikJenisKelamin()
    {
        $db = \Config\Database::connect();

        $query = $db->query("
            SELECT 
                CASE 
                    WHEN jenis_kelamin = 'L' THEN 'Laki-laki'
                    WHEN jenis_kelamin = 'P' THEN 'Perempuan'
                END AS jenis_kelamin,
                COUNT(*) AS jumlah
            FROM tb_data_pekerja
            WHERE deleted_at IS NULL
            AND status_pekerja IN ('Terverifikasi', 'Pensiun', 'Tidak Aktif')
            AND jenis_kelamin IS NOT NULL
            AND jenis_kelamin IN ('L', 'P')
            GROUP BY jenis_kelamin
            ORDER BY jenis_kelamin DESC
        ");

        return $query->getResultArray();
    }
}

if (!function_exists('getStatistikPendidikan')) {
    /**
     * Mendapatkan statistik pegawai berdasarkan tingkat pendidikan
     * 
     * @return array
     */
    function getStatistikPendidikan()
    {
        $db = \Config\Database::connect();

        $query = $db->query("
            SELECT 
                COALESCE(pendidikan, 'Tidak Diketahui') AS tingkat_pendidikan,
                COUNT(*) AS jumlah
            FROM tb_data_pekerja
            WHERE deleted_at IS NULL
            AND status_pekerja IN ('Terverifikasi', 'Pensiun', 'Tidak Aktif')
            GROUP BY pendidikan
            ORDER BY 
                CASE pendidikan
                    WHEN 'SD' THEN 1
                    WHEN 'SMP' THEN 2
                    WHEN 'SMA' THEN 3
                    WHEN 'SMK' THEN 4
                    WHEN 'D3' THEN 5
                    WHEN 'S1' THEN 6
                    WHEN 'S2' THEN 7
                    WHEN 'S3' THEN 8
                    ELSE 9
                END
        ");

        return $query->getResultArray();
    }
}

if (!function_exists('getStatistikPerBidang')) {
    /**
     * Mendapatkan statistik lengkap pegawai per bidang unit kerja
     * Termasuk: status, umur, jenis kelamin, dan pendidikan
     * 
     * @return array
     */
    function getStatistikPerBidang()
    {
        $db = \Config\Database::connect();

        // Subquery untuk mendapatkan riwayat terakhir
        $subquery = $db->table('tb_riwayat_pekerjaan')
            ->select('id_pekerja, MAX(id) as max_id')
            ->where('deleted_at', null)
            ->groupBy('id_pekerja')
            ->getCompiledSelect();

        $query = $db->query("
            SELECT 
                uk.unit_kerja AS bidang,
                uk.id_unit_kerja,
                
                -- Statistik Status Pegawai
                COUNT(DISTINCT CASE WHEN dp.status_pekerja = 'Terverifikasi' 
                    AND DATE_ADD(dp.tanggal_lahir, INTERVAL 58 YEAR) >= NOW() 
                    THEN dp.id_pekerja END) AS aktif,
                COUNT(DISTINCT CASE WHEN dp.status_pekerja = 'Pensiun' THEN dp.id_pekerja END) AS pensiun,
                COUNT(DISTINCT CASE WHEN dp.status_pekerja = 'Tidak Aktif' THEN dp.id_pekerja END) AS tidak_aktif,
                COUNT(DISTINCT dp.id_pekerja) AS total,
                
                -- Statistik Umur per Bidang
                COUNT(DISTINCT CASE WHEN TIMESTAMPDIFF(YEAR, dp.tanggal_lahir, CURDATE()) BETWEEN 20 AND 30 
                    THEN dp.id_pekerja END) AS umur_20_30,
                COUNT(DISTINCT CASE WHEN TIMESTAMPDIFF(YEAR, dp.tanggal_lahir, CURDATE()) BETWEEN 31 AND 40 
                    THEN dp.id_pekerja END) AS umur_31_40,
                COUNT(DISTINCT CASE WHEN TIMESTAMPDIFF(YEAR, dp.tanggal_lahir, CURDATE()) BETWEEN 41 AND 50 
                    THEN dp.id_pekerja END) AS umur_41_50,
                COUNT(DISTINCT CASE WHEN TIMESTAMPDIFF(YEAR, dp.tanggal_lahir, CURDATE()) BETWEEN 51 AND 58 
                    THEN dp.id_pekerja END) AS umur_51_58,
                COUNT(DISTINCT CASE WHEN TIMESTAMPDIFF(YEAR, dp.tanggal_lahir, CURDATE()) > 58 
                    THEN dp.id_pekerja END) AS umur_lebih_58,
                
                -- Statistik Jenis Kelamin per Bidang
                COUNT(DISTINCT CASE WHEN dp.jenis_kelamin = 'L' THEN dp.id_pekerja END) AS jenis_kelamin_laki,
                COUNT(DISTINCT CASE WHEN dp.jenis_kelamin = 'P' THEN dp.id_pekerja END) AS jenis_kelamin_perempuan,
                
                -- Statistik Pendidikan per Bidang
                COUNT(DISTINCT CASE WHEN dp.pendidikan = 'SD' THEN dp.id_pekerja END) AS pendidikan_sd,
                COUNT(DISTINCT CASE WHEN dp.pendidikan = 'SMP' THEN dp.id_pekerja END) AS pendidikan_smp,
                COUNT(DISTINCT CASE WHEN dp.pendidikan = 'SMA' THEN dp.id_pekerja END) AS pendidikan_sma,
                COUNT(DISTINCT CASE WHEN dp.pendidikan = 'SMK' THEN dp.id_pekerja END) AS pendidikan_smk,
                COUNT(DISTINCT CASE WHEN dp.pendidikan = 'D3' THEN dp.id_pekerja END) AS pendidikan_d3,
                COUNT(DISTINCT CASE WHEN dp.pendidikan = 'S1' THEN dp.id_pekerja END) AS pendidikan_s1,
                COUNT(DISTINCT CASE WHEN dp.pendidikan = 'S2' THEN dp.id_pekerja END) AS pendidikan_s2,
                COUNT(DISTINCT CASE WHEN dp.pendidikan = 'S3' THEN dp.id_pekerja END) AS pendidikan_s3
            FROM tb_unit_kerja uk
            LEFT JOIN tb_riwayat_pekerjaan rp ON uk.id_unit_kerja = rp.id_unit_kerja
            LEFT JOIN ($subquery) latest ON rp.id_pekerja = latest.id_pekerja AND rp.id = latest.max_id
            LEFT JOIN tb_data_pekerja dp ON dp.id_pekerja = rp.id_pekerja 
                AND dp.deleted_at IS NULL
                AND dp.status_pekerja IN ('Terverifikasi', 'Pensiun', 'Tidak Aktif')
            WHERE rp.deleted_at IS NULL
            GROUP BY uk.id_unit_kerja, uk.unit_kerja
            HAVING total > 0
            ORDER BY uk.unit_kerja
        ");

        return $query->getResultArray();
    }
}

if (!function_exists('getStatistikBidangById')) {
    /**
     * Mendapatkan statistik pegawai untuk bidang tertentu berdasarkan ID
     * 
     * @param int $idUnitKerja ID Unit Kerja/Bidang
     * @return array|null
     */
    function getStatistikBidangById($idUnitKerja)
    {
        $db = \Config\Database::connect();

        // Subquery untuk mendapatkan riwayat terakhir
        $subquery = $db->table('tb_riwayat_pekerjaan')
            ->select('id_pekerja, MAX(id) as max_id')
            ->where('deleted_at', null)
            ->groupBy('id_pekerja')
            ->getCompiledSelect();

        $query = $db->query("
            SELECT 
                uk.unit_kerja AS bidang,
                uk.id_unit_kerja,
                
                -- Statistik Status Pegawai
                COUNT(DISTINCT CASE WHEN dp.status_pekerja = 'Terverifikasi' 
                    AND DATE_ADD(dp.tanggal_lahir, INTERVAL 58 YEAR) >= NOW() 
                    THEN dp.id_pekerja END) AS aktif,
                COUNT(DISTINCT CASE WHEN dp.status_pekerja = 'Pensiun' THEN dp.id_pekerja END) AS pensiun,
                COUNT(DISTINCT CASE WHEN dp.status_pekerja = 'Tidak Aktif' THEN dp.id_pekerja END) AS tidak_aktif,
                COUNT(DISTINCT dp.id_pekerja) AS total,
                
                -- Statistik Umur per Bidang
                COUNT(DISTINCT CASE WHEN TIMESTAMPDIFF(YEAR, dp.tanggal_lahir, CURDATE()) BETWEEN 20 AND 30 
                    THEN dp.id_pekerja END) AS umur_20_30,
                COUNT(DISTINCT CASE WHEN TIMESTAMPDIFF(YEAR, dp.tanggal_lahir, CURDATE()) BETWEEN 31 AND 40 
                    THEN dp.id_pekerja END) AS umur_31_40,
                COUNT(DISTINCT CASE WHEN TIMESTAMPDIFF(YEAR, dp.tanggal_lahir, CURDATE()) BETWEEN 41 AND 50 
                    THEN dp.id_pekerja END) AS umur_41_50,
                COUNT(DISTINCT CASE WHEN TIMESTAMPDIFF(YEAR, dp.tanggal_lahir, CURDATE()) BETWEEN 51 AND 58 
                    THEN dp.id_pekerja END) AS umur_51_58,
                COUNT(DISTINCT CASE WHEN TIMESTAMPDIFF(YEAR, dp.tanggal_lahir, CURDATE()) > 58 
                    THEN dp.id_pekerja END) AS umur_lebih_58,
                
                -- Statistik Jenis Kelamin per Bidang
                COUNT(DISTINCT CASE WHEN dp.jenis_kelamin = 'L' THEN dp.id_pekerja END) AS jenis_kelamin_laki,
                COUNT(DISTINCT CASE WHEN dp.jenis_kelamin = 'P' THEN dp.id_pekerja END) AS jenis_kelamin_perempuan,
                
                -- Statistik Pendidikan per Bidang
                COUNT(DISTINCT CASE WHEN dp.pendidikan = 'SD' THEN dp.id_pekerja END) AS pendidikan_sd,
                COUNT(DISTINCT CASE WHEN dp.pendidikan = 'SMP' THEN dp.id_pekerja END) AS pendidikan_smp,
                COUNT(DISTINCT CASE WHEN dp.pendidikan = 'SMA' THEN dp.id_pekerja END) AS pendidikan_sma,
                COUNT(DISTINCT CASE WHEN dp.pendidikan = 'SMK' THEN dp.id_pekerja END) AS pendidikan_smk,
                COUNT(DISTINCT CASE WHEN dp.pendidikan = 'D3' THEN dp.id_pekerja END) AS pendidikan_d3,
                COUNT(DISTINCT CASE WHEN dp.pendidikan = 'S1' THEN dp.id_pekerja END) AS pendidikan_s1,
                COUNT(DISTINCT CASE WHEN dp.pendidikan = 'S2' THEN dp.id_pekerja END) AS pendidikan_s2,
                COUNT(DISTINCT CASE WHEN dp.pendidikan = 'S3' THEN dp.id_pekerja END) AS pendidikan_s3
            FROM tb_unit_kerja uk
            LEFT JOIN tb_riwayat_pekerjaan rp ON uk.id_unit_kerja = rp.id_unit_kerja
            LEFT JOIN ($subquery) latest ON rp.id_pekerja = latest.id_pekerja AND rp.id = latest.max_id
            LEFT JOIN tb_data_pekerja dp ON dp.id_pekerja = rp.id_pekerja 
                AND dp.deleted_at IS NULL
                AND dp.status_pekerja IN ('Terverifikasi', 'Pensiun', 'Tidak Aktif')
            WHERE rp.deleted_at IS NULL
            AND uk.id_unit_kerja = ?
            GROUP BY uk.id_unit_kerja, uk.unit_kerja
        ", [$idUnitKerja]);

        $result = $query->getRowArray();
        return $result ?: null;
    }
}

if (!function_exists('getPersentaseStatistik')) {
    /**
     * Menghitung persentase dari statistik
     * 
     * @param int $jumlah Jumlah item
     * @param int $total Total keseluruhan
     * @param int $desimal Jumlah angka desimal (default: 1)
     * @return string
     */
    function getPersentaseStatistik($jumlah, $total, $desimal = 1)
    {
        if ($total == 0) {
            return '0';
        }
        
        $persentase = ($jumlah / $total) * 100;
        return number_format($persentase, $desimal);
    }
}

if (!function_exists('formatStatistikChart')) {
    /**
     * Format data statistik untuk Chart.js
     * 
     * @param array $data Data statistik
     * @param string $labelKey Key untuk label
     * @param string $valueKey Key untuk value
     * @return array
     */
    function formatStatistikChart($data, $labelKey, $valueKey)
    {
        $labels = [];
        $values = [];

        foreach ($data as $item) {
            $labels[] = $item[$labelKey] ?? 'Tidak Diketahui';
            $values[] = (int)($item[$valueKey] ?? 0);
        }

        return [
            'labels' => $labels,
            'values' => $values,
        ];
    }
}

if (!function_exists('getWarnaChart')) {
    /**
     * Mendapatkan array warna untuk chart
     * 
     * @param string $type Tipe warna (blue, green, teal, purple, orange)
     * @return array
     */
    function getWarnaChart($type = 'blue')
    {
        $colors = [
            'blue' => [
                '#3B82F6', // blue-500
                '#60A5FA', // blue-400
                '#93C5FD', // blue-300
                '#BFDBFE', // blue-200
                '#DBEAFE', // blue-100
            ],
            'green' => [
                '#10B981', // green-500
                '#34D399', // green-400
                '#6EE7B7', // green-300
                '#A7F3D0', // green-200
                '#D1FAE5', // green-100
            ],
            'teal' => [
                '#14B8A6', // teal-500
                '#2DD4BF', // teal-400
                '#5EEAD4', // teal-300
                '#99F6E4', // teal-200
                '#CCFBF1', // teal-100
            ],
            'purple' => [
                '#8B5CF6', // purple-500
                '#A78BFA', // purple-400
                '#C4B5FD', // purple-300
                '#DDD6FE', // purple-200
                '#EDE9FE', // purple-100
            ],
            'orange' => [
                '#F97316', // orange-500
                '#FB923C', // orange-400
                '#FDBA74', // orange-300
                '#FED7AA', // orange-200
                '#FFEDD5', // orange-100
            ],
        ];

        return $colors[$type] ?? $colors['blue'];
    }
}

if (!function_exists('generateRingkasanStatistik')) {
    /**
     * Generate ringkasan statistik dalam bentuk teks
     * 
     * @param array $statistik Data statistik
     * @return string
     */
    function generateRingkasanStatistik($statistik)
    {
        $total = $statistik['total'] ?? 0;
        $aktif = $statistik['aktif'] ?? 0;
        $pensiun = $statistik['pensiun'] ?? 0;
        $tidakAktif = $statistik['tidak_aktif'] ?? 0;

        if ($total == 0) {
            return "Belum ada data pegawai.";
        }

        $persenAktif = getPersentaseStatistik($aktif, $total);
        $persenPensiun = getPersentaseStatistik($pensiun, $total);

        return "Dari total <strong>{$total} pegawai</strong>, terdapat <strong>{$aktif} pegawai aktif</strong> ({$persenAktif}%), " .
               "<strong>{$pensiun} pensiun</strong> ({$persenPensiun}%), dan <strong>{$tidakAktif} tidak aktif</strong>.";
    }
}

if (!function_exists('getBadgeStatusPegawai')) {
    /**
     * Mendapatkan HTML badge untuk status pegawai
     * 
     * @param string $status Status pegawai
     * @return string
     */
    function getBadgeStatusPegawai($status)
    {
        $badges = [
            'Terverifikasi' => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">Aktif</span>',
            'Pensiun' => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-teal-100 text-teal-700">Pensiun</span>',
            'Tidak Aktif' => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">Tidak Aktif</span>',
            'Menunggu' => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-700">Menunggu</span>',
        ];

        return $badges[$status] ?? '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-700">Tidak Diketahui</span>';
    }
}
