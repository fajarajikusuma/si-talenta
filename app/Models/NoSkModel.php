<?php

namespace App\Models;

use CodeIgniter\Model;

class NoSkModel extends Model
{
    protected $table      = 'tb_no_sk';
    protected $primaryKey = 'id_no_sk';

    protected $allowedFields = [
        'tahun',
        'kode_sk',
        'nomor_utama',
        'awalan_nomor'
    ];

    protected $useTimestamps = true;
}
