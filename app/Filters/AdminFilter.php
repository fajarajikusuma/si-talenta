<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Blocks non-admin users from accessing the route.
 * Must be used in combination with the global 'login' filter.
 */
class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (! in_array(session()->get('level'), ['admin', 'superadmin'], true)) {
            return redirect()->to(base_url('dashboard'))->with('error', 'Akses ditolak. Halaman ini khusus admin.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
