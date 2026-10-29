<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Hanya superadmin (Fajar Aji Kusuma) yang bisa akses route ini.
 * Semua level lain termasuk admin tidak bisa masuk.
 */
class SuperadminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (session()->get('level') !== 'superadmin') {
            return redirect()->to(base_url('dashboard'))->with('error', 'Akses ditolak. Halaman ini khusus superadmin.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
