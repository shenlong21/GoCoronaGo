<?php

namespace App\Controllers\User;

use CodeIgniter\Controller;
use App\Models\Users_model;
use App\Models\Requests_model;

class Profile_controller extends Controller {

	public function index() {
		$users_model = new Users_model();
		$user_details = $users_model->get_user_details(session('username'));
		
		$access = $user_details['access'];
		$access_level = "Not Definend";

		if($access == 3)
			$access_level = "Admin";
		elseif($access == 2)
			$access_level = "Moderator";
		elseif($access == 1)
			$access_level = "Covid Warrior";
		elseif( $access == 0)
			$access_level = "Not activated";
		else {
			// nothing 
		}

		$req_model = new Requests_model();
		$promote_req = $req_model->check_req($user_details['username']);

			
		$user_details['access_level'] = $access_level;

		$data = [
			'user_details' => $user_details,
			'promote_req' => $promote_req
		];
		
		return view('User/profile', $data);
	}

}
