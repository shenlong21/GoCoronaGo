<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Login implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if(!session()->has('isLoggedIn') || session('isLoggedIn') != TRUE){
            return redirect()->to(base_url('/login'));
        }

        if(!session()->has('username') || is_null(session('username'))){
            return redirect()->to(base_url('/login'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}