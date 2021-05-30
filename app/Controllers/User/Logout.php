<?php

namespace App\Controllers\User;

use CodeIgniter\Controller;
use App\Models\Users_model;

class Logout extends Controller {

	public function index() {
        session()->destroy();
        return redirect()->to('login');

    }

}
