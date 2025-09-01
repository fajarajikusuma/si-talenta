<?php

namespace App\Models;

use CodeIgniter\Model;

class DataPekerjaModel extends Model
{
    protected $table            = 'tb_data_pekerja';
    protected $primaryKey       = 'id_pekerja';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_pekerja', 'nik', 'nama', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'alamat', 'rt/rw', 'desa/kelurahan', 'kecamatan', 'kota_tinggal', 'provinsi', 'ktp', 'kode_pos', 'pendidikan', 'jurusan', 'gelar_depan', 'gelar_belakang', 'ijasah', 'status_pekerja', 'keterangan', 'created_at', 'updated_at', 'deleted_at'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];


    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];


    public function joinDataPekerjaanAktif()
    {
        $id_unit_kerja = session()->get('id_unit_kerja');
        $unit_kerja_nama = strtolower(session()->get('unitKerja'));

        // Cek untuk menampilkan data sesuai id unit kerja
        // $cekUnit = $this->db->table('tb_riwayat_pekerjaan')
        //     ->where('id_unit_kerja', $id_unit_kerja)->countAllResults();

        // $subquery = $this->db->table('tb_riwayat_pekerjaan')
        //     ->select('id_pekerja, MAX(id) as id')
        //     ->where('deleted_at', null)
        //     ->groupBy('id_pekerja');

        $sub = $this->db->table('tb_riwayat_pekerjaan r2')
            ->select('1')
            ->where('r2.deleted_at IS NULL')
            ->where('r2.id_pekerja = r1.id_pekerja', null, false)
            ->where('r2.tmt_kerja > r1.tmt_kerja');

        $subquery_builder = $this->db->table('tb_riwayat_pekerjaan r1')
            ->select('r1.id_pekerja, r1.id')
            ->where('r1.deleted_at IS NULL')
            ->where("NOT EXISTS (" . $sub->getCompiledSelect(false) . ")", null, false);

        $builder = $this->db->table('tb_data_pekerja');
        $builder->select('
            tb_data_pekerja.*,
            tb_riwayat_pekerjaan.*,
            tb_nama_pekerjaan.pekerjaan,
            tb_unit_kerja.*
        ');

        // Join subquery sebagai latest_riwayat
        $builder->join('(' . $subquery_builder->getCompiledSelect() . ') as latest_riwayat', 'latest_riwayat.id_pekerja = tb_data_pekerja.id_pekerja');

        // Join tb_riwayat_pekerjaan berdasarkan ID riwayat kerja terbaru
        $builder->join('tb_riwayat_pekerjaan', 'tb_riwayat_pekerjaan.id = latest_riwayat.id', 'left');
        $builder->join('tb_nama_pekerjaan', 'tb_nama_pekerjaan.id_nama_pekerjaan = tb_riwayat_pekerjaan.id_nama_pekerjaan', 'left');
        $builder->join('tb_unit_kerja', 'tb_unit_kerja.id_unit_kerja = tb_riwayat_pekerjaan.id_unit_kerja', 'left');

        $builder->where('tb_data_pekerja.deleted_at', null);
        $builder->where('tb_data_pekerja.status_pekerja', 'Terverifikasi');
        // if ($cekUnit > 0) {
        //     $builder->where('tb_riwayat_pekerjaan.id_unit_kerja', $id_unit_kerja);
        // }
        // Filter berdasarkan unit kerja jika bukan DLH
        if ($unit_kerja_nama != 'dinas lingkungan hidup') {
            $builder->where('tb_riwayat_pekerjaan.id_unit_kerja', $id_unit_kerja);
        }

        $builder->where('DATE_ADD(tb_data_pekerja.tanggal_lahir, INTERVAL 58 YEAR) >= NOW()');
        // $builder->orderBy('tb_data_pekerja.created_at', 'ASC');
        // kelompokan perbidang 
        $builder->groupBy('tb_riwayat_pekerjaan.id_unit_kerja, tb_data_pekerja.id_pekerja');

        return $builder->get()->getResultArray();
    }

    public function joinDataPekerjaanPensiun()
    {
        $id_unit_kerja = session()->get('id_unit_kerja');
        $unit_kerja_nama = strtolower(session()->get('unitKerja'));

        // Cek untuk menampilkan data sesuai id unit kerja
        // $cekUnit = $this->db->table('tb_riwayat_pekerjaan')
        //     ->where('id_unit_kerja', $id_unit_kerja)->countAllResults();

        $subquery = $this->db->table('tb_riwayat_pekerjaan')
            ->select('id_pekerja, MAX(id) as id')
            ->where('deleted_at', null)
            ->groupBy('id_pekerja');

        $builder = $this->db->table('tb_data_pekerja');
        $builder->select('
            tb_data_pekerja.*,
            tb_riwayat_pekerjaan.*,
            tb_nama_pekerjaan.pekerjaan,
            tb_unit_kerja.unit_kerja,
            DATE_ADD(tb_data_pekerja.tanggal_lahir, INTERVAL 58 YEAR) AS tanggal_pensiun
        ');

        // Join subquery sebagai latest_riwayat
        $builder->join('(' . $subquery->getCompiledSelect() . ') as latest_riwayat', 'latest_riwayat.id_pekerja = tb_data_pekerja.id_pekerja');

        // Join tb_riwayat_pekerjaan berdasarkan ID riwayat kerja terbaru
        $builder->join('tb_riwayat_pekerjaan', 'tb_riwayat_pekerjaan.id = latest_riwayat.id', 'left');
        $builder->join('tb_nama_pekerjaan', 'tb_nama_pekerjaan.id_nama_pekerjaan = tb_riwayat_pekerjaan.id_nama_pekerjaan', 'left');
        $builder->join('tb_unit_kerja', 'tb_unit_kerja.id_unit_kerja = tb_riwayat_pekerjaan.id_unit_kerja', 'left');

        $builder->where('tb_data_pekerja.deleted_at', null);
        $builder->where('tb_data_pekerja.status_pekerja', 'Pensiun');
        // if ($cekUnit > 0) {
        //     dd($builder->where('tb_riwayat_pekerjaan.id_unit_kerja', $id_unit_kerja));
        // }
        if ($unit_kerja_nama != 'dinas lingkungan hidup') {
            $builder->where('tb_riwayat_pekerjaan.id_unit_kerja', $id_unit_kerja);
        }
        // $builder->where('DATE_ADD(tb_data_pekerja.tanggal_lahir, INTERVAL 58 YEAR) >= NOW()');
        $builder->orderBy('tb_data_pekerja.created_at', 'ASC');
        return $builder->get()->getResultArray();
    }

    public function joinDataPekerjaanTidakAktif()
    {
        $id_unit_kerja = session()->get('id_unit_kerja');
        $unit_kerja_nama = strtolower(session()->get('unitKerja'));

        // Cek untuk menampilkan data sesuai id unit kerja
        // $cekUnit = $this->db->table('tb_riwayat_pekerjaan')
        //     ->where('id_unit_kerja', $id_unit_kerja)->countAllResults();
        $subquery = $this->db->table('tb_riwayat_pekerjaan')
            ->select('id_pekerja, MAX(id) as id')
            ->where('deleted_at', null)
            ->groupBy('id_pekerja');

        $builder = $this->db->table('tb_data_pekerja');
        $builder->select('
            tb_data_pekerja.*,
            tb_riwayat_pekerjaan.*,
            tb_nama_pekerjaan.pekerjaan,
            tb_unit_kerja.unit_kerja
        ');

        // Join subquery sebagai latest_riwayat
        $builder->join('(' . $subquery->getCompiledSelect() . ') as latest_riwayat', 'latest_riwayat.id_pekerja = tb_data_pekerja.id_pekerja');

        // Join tb_riwayat_pekerjaan berdasarkan ID riwayat kerja terbaru
        $builder->join('tb_riwayat_pekerjaan', 'tb_riwayat_pekerjaan.id = latest_riwayat.id', 'left');
        $builder->join('tb_nama_pekerjaan', 'tb_nama_pekerjaan.id_nama_pekerjaan = tb_riwayat_pekerjaan.id_nama_pekerjaan', 'left');
        $builder->join('tb_unit_kerja', 'tb_unit_kerja.id_unit_kerja = tb_riwayat_pekerjaan.id_unit_kerja', 'left');

        $builder->where('tb_data_pekerja.deleted_at', null);
        $builder->where('tb_data_pekerja.status_pekerja', 'Tidak Aktif');
        // if ($cekUnit > 0) {
        //     $builder->where('tb_riwayat_pekerjaan.id_unit_kerja', $id_unit_kerja);
        // }
        if ($unit_kerja_nama != 'dinas lingkungan hidup') {
            $builder->where('tb_riwayat_pekerjaan.id_unit_kerja', $id_unit_kerja);
        }
        // $builder->where('DATE_ADD(tb_data_pekerja.tanggal_lahir, INTERVAL 58 YEAR) >= NOW()');
        $builder->orderBy('tb_data_pekerja.created_at', 'ASC');

        return $builder->get()->getResultArray();
    }

    public function joinDataPekerjaanBaru()
    {
        $id_unit_kerja = session()->get('id_unit_kerja');
        $unit_kerja_nama = strtolower(session()->get('unitKerja'));
        // Cek untuk menampilkan data sesuai id unit kerja
        // $cekUnit = $this->db->table('tb_riwayat_pekerjaan')
        //     ->where('id_unit_kerja', $id_unit_kerja)->countAllResults();
        $builder = $this->db->table('tb_data_pekerja');
        $builder->select('
        tb_data_pekerja.*,
        tb_riwayat_pekerjaan.*,
        tb_nama_pekerjaan.pekerjaan,
        tb_unit_kerja.unit_kerja
        ');

        // JOIN tb_riwayat_pekerjaan dulu!
        $builder->join('tb_riwayat_pekerjaan', 'tb_riwayat_pekerjaan.id_pekerja = tb_data_pekerja.id_pekerja', 'left');
        $builder->join('tb_nama_pekerjaan', 'tb_nama_pekerjaan.id_nama_pekerjaan = tb_riwayat_pekerjaan.id_nama_pekerjaan', 'left');
        $builder->join('tb_unit_kerja', 'tb_unit_kerja.id_unit_kerja = tb_riwayat_pekerjaan.id_unit_kerja', 'left');

        $builder->where('tb_data_pekerja.deleted_at', null);
        $builder->where('tb_riwayat_pekerjaan.deleted_at', null);
        $builder->where('tb_data_pekerja.status_pekerja', 'Menunggu');
        $builder->where('tb_riwayat_pekerjaan.status', 'Menunggu');
        // if ($cekUnit > 0) {
        //     $builder->where('tb_riwayat_pekerjaan.id_unit_kerja', $id_unit_kerja);
        // }
        if ($unit_kerja_nama != 'dinas lingkungan hidup') {
            $builder->where('tb_riwayat_pekerjaan.id_unit_kerja', $id_unit_kerja);
        }
        $builder->orderBy('tb_data_pekerja.created_at', 'ASC');

        return $builder->get()->getResultArray();
    }

    public function editDataPekerja($id_pekerja)
    {
        $builder = $this->db->table('tb_data_pekerja');
        $builder->select('tb_data_pekerja.*, tb_riwayat_pekerjaan.*');
        $builder->join('tb_riwayat_pekerjaan', 'tb_riwayat_pekerjaan.id_pekerja = tb_data_pekerja.id_pekerja', 'left');
        $builder->where('tb_data_pekerja.deleted_at', null);
        $builder->where('tb_riwayat_pekerjaan.deleted_at', null);
        $builder->where('tb_data_pekerja.id_pekerja', $id_pekerja);
        return $builder->get()->getRowArray();
    }

    public function getDataPekerjaById($id_pekerja)
    {
        $builder = $this->db->table('tb_data_pekerja');

        // Subquery untuk mendapatkan id riwayat pekerjaan terakhir berdasarkan tmt_kerja
        $subQuery = $this->db->table('tb_riwayat_pekerjaan')
            ->select('id')
            ->where('id_pekerja', $id_pekerja)
            ->where('deleted_at', null)
            ->orderBy('tmt_kerja', 'DESC')
            ->limit(1)
            ->getCompiledSelect();

        $builder->select('
        tb_data_pekerja.*,
        tb_riwayat_pekerjaan.*,
        tb_nama_pekerjaan.pekerjaan,
        tb_unit_kerja.unit_kerja,
        DATE_ADD(tb_data_pekerja.tanggal_lahir, INTERVAL 58 YEAR) AS tanggal_pensiun
    ');
        $builder->join('tb_riwayat_pekerjaan', "tb_riwayat_pekerjaan.id = ($subQuery)", 'left', false);
        $builder->join('tb_nama_pekerjaan', 'tb_nama_pekerjaan.id_nama_pekerjaan = tb_riwayat_pekerjaan.id_nama_pekerjaan', 'left');
        $builder->join('tb_unit_kerja', 'tb_unit_kerja.id_unit_kerja = tb_riwayat_pekerjaan.id_unit_kerja', 'left');
        $builder->where('tb_data_pekerja.deleted_at', null);
        $builder->where('tb_data_pekerja.id_pekerja', $id_pekerja);

        return $builder->get()->getRowArray();
    }

    public function updateStatusPensiunOtomatis()
    {
        $builder = $this->db->table('tb_data_pekerja');
        $builder->select('tb_data_pekerja.id_pekerja');
        $builder->join('tb_riwayat_pekerjaan', 'tb_riwayat_pekerjaan.id_pekerja = tb_data_pekerja.id_pekerja', 'left');
        $builder->where('DATE_ADD(tb_data_pekerja.tanggal_lahir, INTERVAL 58 YEAR) <= CURDATE()');
        $builder->where('tb_data_pekerja.deleted_at', null);
        $builder->where('tb_riwayat_pekerjaan.status !=', 'Tidak Aktif');
        $builder->where('tb_data_pekerja.status_pekerja !=', 'Tidak Aktif');
        $builder->groupBy('tb_data_pekerja.id_pekerja'); // supaya id_pekerja unik

        $result = $builder->get()->getResult();

        foreach ($result as $row) {
            $this->db->table('tb_data_pekerja')
                ->where('id_pekerja', $row->id_pekerja)
                ->update(['status_pekerja' => 'Pensiun']);
        }
    }


    // public function updateStatusAktifOtomatis()
    // {
    //     $builder = $this->db->table('tb_data_pekerja');
    //     $builder->select('tb_riwayat_pekerjaan.id');
    //     $builder->join('tb_riwayat_pekerjaan', 'tb_riwayat_pekerjaan.id_pekerja = tb_data_pekerja.id_pekerja', 'left');
    //     $builder->where('DATE_ADD(tb_data_pekerja.tanggal_lahir, INTERVAL 58 YEAR) > CURDATE()');
    //     $builder->where('tb_data_pekerja.deleted_at', null);
    //     $builder->where('tb_riwayat_pekerjaan.status !=', 'Terverifikasi');

    //     $result = $builder->get()->getResult();

    //     foreach ($result as $row) {
    //         $this->db->table('tb_riwayat_pekerjaan')
    //             ->where('id', $row->id)
    //             ->update(['status' => 'Terverifikasi']);
    //     }
    // }

    // public function getDataPensiun($tahun = null)
    // {
    //     // Subquery untuk mengambil riwayat terakhir tiap pekerja
    //     $sub = $this->db->table('tb_riwayat_pekerjaan as tr1')
    //         ->select('tr1.*')
    //         ->join(
    //             '(SELECT id_pekerja, MAX(id) AS max_id FROM tb_riwayat_pekerjaan GROUP BY id_pekerja) as tr2',
    //             'tr1.id_pekerja = tr2.id_pekerja AND tr1.id = tr2.max_id'
    //         );

    //     // Gabungkan dengan data pekerja
    //     $builder = $this->db->table('tb_data_pekerja');
    //     $builder->select('
    //         tb_data_pekerja.*,
    //         riwayat_terakhir.id_nama_pekerjaan,
    //         riwayat_terakhir.id_unit_kerja,
    //         tb_nama_pekerjaan.pekerjaan,
    //         tb_unit_kerja.unit_kerja,
    //         DATE_ADD(tb_data_pekerja.tanggal_lahir, INTERVAL 58 YEAR) AS tanggal_pensiun
    //     ');
    //     $builder->join('(' . $sub->getCompiledSelect() . ') as riwayat_terakhir', 'riwayat_terakhir.id_pekerja = tb_data_pekerja.id_pekerja', 'left');
    //     $builder->join('tb_nama_pekerjaan', 'tb_nama_pekerjaan.id_nama_pekerjaan = riwayat_terakhir.id_nama_pekerjaan', 'left');
    //     $builder->join('tb_unit_kerja', 'tb_unit_kerja.id_unit_kerja = riwayat_terakhir.id_unit_kerja', 'left');
    //     $builder->where('tb_data_pekerja.deleted_at', null);
    //     $builder->where('tb_data_pekerja.status_pekerja', 'Terverifikasi');

    //     if ($tahun) {
    //         $builder->where('YEAR(DATE_ADD(tb_data_pekerja.tanggal_lahir, INTERVAL 58 YEAR))', $tahun);
    //     } else {
    //         $builder->where('YEAR(DATE_ADD(tb_data_pekerja.tanggal_lahir, INTERVAL 58 YEAR))', date('Y'));
    //     }

    //     // Tambahkan kondisi untuk unit kerja
    //     $unit_kerja_nama = strtolower(session()->get('unitKerja'));
    //     if ($unit_kerja_nama != 'dinas lingkungan hidup') {
    //         $id_unit_kerja = session()->get('id_unit_kerja');
    //         $builder->where('riwayat_terakhir.id_unit_kerja', $id_unit_kerja);
    //     }

    //     $builder->orderBy('tb_data_pekerja.created_at', 'ASC');
    //     return $builder->get()->getResultArray();
    // }

    public function getDataPensiun($tahun = null)
    {
        $builder = $this->db->table('tb_data_pekerja');
        $builder->select('
            tb_data_pekerja.*,
            tb_nama_pekerjaan.pekerjaan,
            tb_unit_kerja.unit_kerja
        ');
        $builder->join('tb_riwayat_pekerjaan AS riwayat_terakhir', 'riwayat_terakhir.id_pekerja = tb_data_pekerja.id_pekerja AND riwayat_terakhir.status = "Terverifikasi"', 'left');
        $builder->join('tb_nama_pekerjaan', 'tb_nama_pekerjaan.id_nama_pekerjaan = riwayat_terakhir.id_nama_pekerjaan', 'left');
        $builder->join('tb_unit_kerja', 'tb_unit_kerja.id_unit_kerja = riwayat_terakhir.id_unit_kerja', 'left');

        // Tambahkan kondisi untuk unit kerja
        $unit_kerja_nama = strtolower(session()->get('unitKerja'));
        if ($unit_kerja_nama != 'dinas lingkungan hidup') {
            $id_unit_kerja = session()->get('id_unit_kerja');
            $builder->where('riwayat_terakhir.id_unit_kerja', $id_unit_kerja);
        }

        $result = $builder->get()->getResultArray();
        // dd($result);

        // Tambahkan tanggal pensiun dan filter berdasarkan tahun jika diminta
        $filtered = [];
        foreach ($result as $row) {
            $tanggal_lahir = $row['tanggal_lahir'];

            // Ambil bulan dan tahun lahir
            $bulan_lahir = date('m', strtotime($tanggal_lahir));
            $tahun_lahir = date('Y', strtotime($tanggal_lahir));

            // Hitung tahun pensiun
            $tahun_pensiun = $tahun_lahir + 58;
            $bulan_pensiun = (int)$bulan_lahir + 1;

            // Jika bulan pensiun lebih dari 12, maka reset ke 1 dan naikkan tahun
            if ($bulan_pensiun > 12) {
                $bulan_pensiun = 1;
                $tahun_pensiun += 1;
            }

            // Format tanggal pensiun
            $tanggal_pensiun = sprintf('%04d-%02d-01', $tahun_pensiun, $bulan_pensiun);
            $row['tanggal_pensiun'] = $tanggal_pensiun;

            // Filter tahun
            if ($tahun) {
                if (date('Y', strtotime($tanggal_pensiun)) == $tahun) {
                    $filtered[] = $row;
                }
            } else {
                if (date('Y', strtotime($tanggal_pensiun)) == date('Y')) {
                    $filtered[] = $row;
                }
            }
        }
        // dd($filtered);
        return $filtered;
    }


    public function dataPengajuanPekerjaan()
    {
        $id_unit_kerja   = session()->get('id_unit_kerja');
        $tahun_sekarang  = (int)date('Y');
        $hasil           = [];

        // Ambil nama unit kerja dari id_unit_kerja
        $unit_kerja_row = $this->db->table('tb_unit_kerja')
            ->select('unit_kerja')
            ->where('id_unit_kerja', $id_unit_kerja)
            ->get()
            ->getRow();

        $nama_unit_kerja = $unit_kerja_row->unit_kerja ?? '';

        // Ambil semua pegawai yang aktif dan terverifikasi
        $pegawai = $this->db->table('tb_data_pekerja')
            ->where('deleted_at', null)
            ->where('status_pekerja', 'Terverifikasi')
            ->get()
            ->getResult();

        foreach ($pegawai as $p) {
            $builder = $this->db->table('tb_riwayat_pekerjaan')
                ->select('MAX(tahun) as tahun_terakhir')
                ->where('id_pekerja', $p->id_pekerja)
                ->where('deleted_at', null);

            if (strtolower($nama_unit_kerja) !== 'dinas lingkungan hidup') {
                $builder->where('id_unit_kerja', $id_unit_kerja);
            }

            $row = $builder->get()->getRow();
            $tahun_terakhir = (int)($row->tahun_terakhir ?? 0);

            if ($tahun_terakhir < $tahun_sekarang) {
                $dataQuery = $this->db->table('tb_data_pekerja')
                    ->select('
                        tb_data_pekerja.*,
                        tb_riwayat_pekerjaan.status as status_terbaru,
                        tb_nama_pekerjaan.pekerjaan,
                        tb_unit_kerja.unit_kerja
                ')
                    ->join('tb_riwayat_pekerjaan', 'tb_riwayat_pekerjaan.id_pekerja = tb_data_pekerja.id_pekerja', 'left')
                    ->join('tb_nama_pekerjaan', 'tb_nama_pekerjaan.id_nama_pekerjaan = tb_riwayat_pekerjaan.id_nama_pekerjaan', 'left')
                    ->join('tb_unit_kerja', 'tb_unit_kerja.id_unit_kerja = tb_riwayat_pekerjaan.id_unit_kerja', 'left')
                    ->where('tb_data_pekerja.id_pekerja', $p->id_pekerja)
                    ->orderBy('tb_riwayat_pekerjaan.created_at', 'DESC')
                    ->limit(1);

                if (strtolower($nama_unit_kerja) !== 'dinas lingkungan hidup') {
                    $dataQuery->where('tb_riwayat_pekerjaan.id_unit_kerja', $id_unit_kerja);
                }

                $data = $dataQuery->get()->getRowArray();

                if ($data) {
                    $hasil[] = $data;
                }
            }
        }
        return $hasil;
    }

    public function getDataPenugasanMenunggu()
    {
        $id_unit_kerja = session()->get('id_unit_kerja');

        //Cek apakah unit kerja punya data 'Menunggu'
        $hasData = $this->db->table('tb_riwayat_pekerjaan')
            ->join('tb_data_pekerja', 'tb_data_pekerja.id_pekerja = tb_riwayat_pekerjaan.id_pekerja')
            ->where('tb_riwayat_pekerjaan.status', 'Menunggu')
            ->where('tb_data_pekerja.deleted_at', null)
            ->where('tb_data_pekerja.status_pekerja', 'Terverifikasi')
            ->where('tb_riwayat_pekerjaan.deleted_at', null)
            ->where('tb_riwayat_pekerjaan.id_unit_kerja', $id_unit_kerja)
            ->countAllResults();

        $subquery = $this->db->table('tb_riwayat_pekerjaan')
            ->select('id_pekerja, MAX(id) as id')
            ->where('status', 'Menunggu')
            ->where('deleted_at', null)
            ->groupBy('id_pekerja');

        $builder = $this->db->table('tb_data_pekerja');
        $builder->select('
        tb_data_pekerja.*,
        tb_riwayat_pekerjaan.*,
        tb_nama_pekerjaan.pekerjaan,
        tb_unit_kerja.unit_kerja
    ');

        $builder->join('(' . $subquery->getCompiledSelect() . ') as latest_riwayat', 'latest_riwayat.id_pekerja = tb_data_pekerja.id_pekerja');
        $builder->join('tb_riwayat_pekerjaan', 'tb_riwayat_pekerjaan.id = latest_riwayat.id', 'left');
        $builder->join('tb_nama_pekerjaan', 'tb_nama_pekerjaan.id_nama_pekerjaan = tb_riwayat_pekerjaan.id_nama_pekerjaan', 'left');
        $builder->join('tb_unit_kerja', 'tb_unit_kerja.id_unit_kerja = tb_riwayat_pekerjaan.id_unit_kerja', 'left');

        $builder->where('tb_data_pekerja.deleted_at', null);
        $builder->where('tb_data_pekerja.status_pekerja', 'Terverifikasi');
        $builder->where('tb_riwayat_pekerjaan.status', 'Menunggu');
        $builder->where('DATE_ADD(tb_data_pekerja.tanggal_lahir, INTERVAL 58 YEAR) >= NOW()');

        // Jika unit kerja tidak memiliki data "Menunggu", tampilkan semua
        if ($hasData > 0) {
            $builder->where('tb_unit_kerja.id_unit_kerja', $id_unit_kerja);
        }

        $builder->orderBy('tb_data_pekerja.created_at', 'ASC');
        // dd($builder->get()->getResultArray());

        return $builder->get()->getResultArray();
    }

    public function getDataPenugasanMenungguByUnit($idUnitKerja)
    {
        $subquery = $this->db->table('tb_riwayat_pekerjaan')
            ->select('id_pekerja, MAX(id) as id')
            ->where('status', 'Menunggu')
            ->where('deleted_at', null)
            ->groupBy('id_pekerja');

        $builder = $this->db->table('tb_data_pekerja');
        $builder->select('
        tb_data_pekerja.*,
        tb_riwayat_pekerjaan.*,
        tb_nama_pekerjaan.pekerjaan,
        tb_unit_kerja.unit_kerja
    ');
        $builder->join('(' . $subquery->getCompiledSelect() . ') as latest_riwayat', 'latest_riwayat.id_pekerja = tb_data_pekerja.id_pekerja');
        $builder->join('tb_riwayat_pekerjaan', 'tb_riwayat_pekerjaan.id = latest_riwayat.id', 'left');
        $builder->join('tb_nama_pekerjaan', 'tb_nama_pekerjaan.id_nama_pekerjaan = tb_riwayat_pekerjaan.id_nama_pekerjaan', 'left');
        $builder->join('tb_unit_kerja', 'tb_unit_kerja.id_unit_kerja = tb_riwayat_pekerjaan.id_unit_kerja', 'left');
        $builder->where('tb_data_pekerja.deleted_at', null);
        $builder->where('tb_data_pekerja.status_pekerja', 'Terverifikasi');
        $builder->where('tb_riwayat_pekerjaan.status', 'Menunggu');
        $builder->where('tb_riwayat_pekerjaan.id_unit_kerja', $idUnitKerja);
        $builder->where('DATE_ADD(tb_data_pekerja.tanggal_lahir, INTERVAL 58 YEAR) >= NOW()');
        $builder->orderBy('tb_data_pekerja.created_at', 'ASC');
        return $builder->get()->getResultArray();
    }

    public function hasDataPenugasanMenunggu()
    {
        $idUnitKerja = session()->get('id_unit_kerja');
        if ($idUnitKerja) {
            $count = $this->db->table('tb_riwayat_pekerjaan')
                ->join('tb_data_pekerja', 'tb_data_pekerja.id_pekerja = tb_riwayat_pekerjaan.id_pekerja')
                ->where('tb_riwayat_pekerjaan.status', 'Menunggu')
                ->where('tb_data_pekerja.deleted_at', null)
                ->where('tb_data_pekerja.status_pekerja', 'Terverifikasi')
                ->where('tb_riwayat_pekerjaan.deleted_at', null)
                ->where('tb_riwayat_pekerjaan.id_unit_kerja', $idUnitKerja)
                ->countAllResults();
        }
        return false;
    }
}
