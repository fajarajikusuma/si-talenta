<?php

namespace App\Models;

use CodeIgniter\Model;

class SkModel extends Model
{
    protected $table      = 'tb_sk';
    protected $primaryKey = 'id_sk';

    protected $allowedFields = [
        'id_pekerja',
        'id_no_sk',
        'nomor_sk'
    ];

    protected $useTimestamps = false;
}
