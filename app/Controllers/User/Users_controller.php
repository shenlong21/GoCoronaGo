<?php

namespace App\Controllers\User;

use CodeIgniter\Controller;
use App\Controllers\BaseController;
use App\Models\Users_model;
use App\Models\Activities_model;

class Users_controller extends BaseController {

	public function index() {
        if($this->session->get('access') <= 2 )
            return redirect()->to('access-denied');
        
		$users_model = new Users_model();
		$users = $users_model->get_all_users();

		$activities_model = new Activities_model();
		$activity = $activities_model->get_last_activities();
        
		$data = [
            'users' => $users,
			'activities' => $activity
		];
		
		return view('User/users', $data);
	}

	public function promote(){
		if($this->session->get('access') <= 2 )
            return redirect()->to('access-denied');

		if($this->request->getMethod() == "post") {
			if($this->validate([
				'username' => 'required|alpha_numeric'
			])){
				$users_model = new Users_model();
				$promote = $users_model->promote_user($this->request->getPost('username'));
				
				if( $promote == FALSE )
					return \json_encode(['promote_response', 'error']);				
				
				return \json_encode(['promote_response'=> 'success', 'access' => $promote]);			
			}
			else{
				return \json_encode(['promote_response'=> 'validation_error']);
			}
		}
	}

	public function demote(){
		if($this->session->get('access') <= 2 )
            return redirect()->to('access-denied');

		if($this->request->getMethod() == "post") {
			if($this->validate([
				'username' => 'required|alpha_numeric'
			])){
				$users_model = new Users_model();

				$demote = $users_model->demote_user($this->request->getPost('username'));

				if($demote == FALSE)
					return \json_encode(['promote_response'=> 'error']);
				
				return \json_encode(['promote_response'=> 'success', 'access' => $demote]);
			}
			else{
				return \json_encode(['promote_response'=> 'validation_error']);
			}
		}
	}



}
