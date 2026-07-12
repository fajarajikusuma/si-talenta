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
        'nomor_sk',
        'tanggal_penetapan'  // 🔧 PERBAIKAN: Tambahkan field tanggal_penetapan
    ];

    protected $useTimestamps = false;
}
