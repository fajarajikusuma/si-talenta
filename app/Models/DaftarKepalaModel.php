<?php

namespace App\Models;

use CodeIgniter\Model;

class DaftarKepalaModel extends Model
{
    protected $table            = 'tb_kepala';
    protected $primaryKey       = 'id_kepala';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_kepala',
        'nip',
        'nama_kepala',
        'id_unit_kerja',
        'jabatan',
        'jabatan_short',
        'keterangan',
        'status'
    ];

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

    // get daftar kepala join unit kerja
    public function getDaftarKepala()
    {
        return $this->db->table('tb_kepala')
            ->select('tb_kepala.*, tb_unit_kerja.unit_kerja')
            ->join('tb_unit_kerja', 'tb_kepala.id_unit_kerja = tb_unit_kerja.id_unit_kerja')
            ->get()->getResultArray();
    }
}
