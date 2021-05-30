<?php

namespace App\Controllers\User;

use CodeIgniter\Controller;
use App\Controllers\BaseController;
use App\Models\Users_model;
use App\Models\Activities_model;

class Logs extends BaseController {

	public function index() {
        if($this->session->get('access') <= 2 )
            return redirect()->to('access-denied');


		$activities_model = new Activities_model();
		$activity = $activities_model->get_all_activities();

		$data = [
			'activities' => $activity
		];

		return view('User/logs', $data);
	}


}
