<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Ajax extends BaseController
{
    public function penugasanBadge()
    {
        $jumlah = jumlah_penugasan_pending();

        if ($jumlah <= 0) {
            return $this->response->setJSON(['badge' => '']);
        }

        $warna = ($jumlah <= 3) ? 'bg-warning text-dark' : 'bg-danger';

        return $this->response->setJSON([
            'badge' => '<span class="badge rounded-circle ' . $warna . ' ms-2 d-inline-flex align-items-center justify-content-center"
        style="width:18px;height:18px;font-size:11px;line-height:1;">' . $jumlah . '</span>'
        ]);
    }
}
