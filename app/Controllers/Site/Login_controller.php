<?php

namespace App\Controllers\Site;

use CodeIgniter\Controller;
use App\Models\Users_model;
use App\Controllers\BaseController;

class Login_controller extends BaseController {

	public function authenticate() {
        $users_model = new Users_model();
        
        // if session is still on
		if ( session()->has('isLoggedIn') && session('isLoggedIn') == TRUE && session()->has('username') && !is_null(session('username') )) {
            if($users_model->check_if_username(session('username')))
            return redirect()->to(base_url('/user/profile'));
        }         
        
        if ( $this->request->getMethod() == 'post' ) {
            
            $users_model = new Users_model();
            // $session = \Config\Services::session();;
            if ( $this->validate([
                'role' => 'required|in_list[covidWarrior,moderator,admin]',
                'username' => 'required|alpha_numeric',
                'password' => 'required'
            ]) ){
                $role = $this->request->getPost('role');
                $username = $this->request->getPost('username');
                $password = $this->request->getPost('password');

                // setting role values
                if($role == "admin")
                    $role = 3;
                elseif($role == "moderator")
                    $role = 2;
                else    
                    $role = 1;

                // verify user
                if($users_model->verify_user($username, $password, $role)){
                    $sessionData = [
                        'isLoggedIn' => TRUE,
                        'username' => $username,
                        'access' => $role
                    ];
                    $this->session->set($sessionData);
                    return redirect()->to('/user/profile');
                }

                // check if account is deactivated
                if($users_model->check_deactivated($username, $password)){
                    // do something
                    $this->session->setFlashData('login_response', 'account_deactivated');
                    return redirect()->to('/login');
                }

                echo "validation fails";
                $this->session->setFlashData('login_response', 'verification_fails');
                return redirect()->to('/login');
            }
            else{
                // validation error
                echo "validation fails 2";

                $this->session->setFlashData('login_response', 'valdation_error');
                return redirect()->to('/login');
            }
        }


    }

}
