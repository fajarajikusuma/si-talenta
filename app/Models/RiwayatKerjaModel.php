<?php

namespace App\Models;

use CodeIgniter\Model;

class RiwayatKerjaModel extends Model
{
    protected $table            = 'tb_riwayat_pekerjaan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'id_pekerja', 'id_nama_pekerjaan', 'jenis_pegawai', 'id_unit_kerja', 'tahun', 'tmt_kerja', 'tst_kerja', 'status', 'gaji', 'uraian_pekerjaan', 'sk_spt', 'sk_pks', 'penginput', 'created_at', 'updated_at', 'deleted_at'];

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

    public function getRiwayatKerjaById($id_pekerja)
    {
        $builder = $this->db->table('tb_riwayat_pekerjaan');
        $builder->select('tb_riwayat_pekerjaan.*, tb_nama_pekerjaan.pekerjaan, tb_unit_kerja.unit_kerja, tb_data_pekerja.nama');
        $builder->join('tb_nama_pekerjaan', 'tb_nama_pekerjaan.id_nama_pekerjaan = tb_riwayat_pekerjaan.id_nama_pekerjaan', 'left');
        $builder->join('tb_unit_kerja', 'tb_unit_kerja.id_unit_kerja = tb_riwayat_pekerjaan.id_unit_kerja', 'left');
        $builder->join('tb_data_pekerja', 'tb_data_pekerja.id_pekerja = tb_riwayat_pekerjaan.id_pekerja', 'left');
        $builder->where('tb_riwayat_pekerjaan.deleted_at', null);
        $builder->where('tb_riwayat_pekerjaan.id_pekerja', $id_pekerja);
        // Sort by tmt_kerja in descending order
        $builder->orderBy('tb_riwayat_pekerjaan.tahun', 'ASC');
        return $builder->get()->getResultArray();
    }

    public function getRiwayatTerakhir($idPekerja)
    {
        return $this->where('id_pekerja', $idPekerja)
            ->orderBy('tmt', 'DESC')
            ->first();
    }
}
