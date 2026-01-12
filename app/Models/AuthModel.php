<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthModel extends Model
{
    protected $table            = 'tb_user';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'id_unit_kerja', 'nama_lengkap', 'email', 'no_hp', 'alamat', 'foto', 'username', 'password', 'level', 'status'];

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

    public function getUser()
    {
        // join with unit_kerja table to get unit_kerja name
        return $this->select('tb_user.*, tb_unit_kerja.unit_kerja')
            ->join('tb_unit_kerja', 'tb_user.id_unit_kerja = tb_unit_kerja.id_unit_kerja', 'left')
            ->findAll();
    }

    public function getUserById($id)
    {
        // join with unit_kerja table to get unit_kerja name
        return $this->select('tb_user.*, tb_unit_kerja.unit_kerja')
            ->join('tb_unit_kerja', 'tb_user.id_unit_kerja = tb_unit_kerja.id_unit_kerja', 'left')
            ->where('tb_user.id', $id)
            ->first();
    }
}
