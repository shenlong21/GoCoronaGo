<?php

namespace App\Controllers\User;

use CodeIgniter\Controller;
use App\Models\Users_model;
use App\Controllers\BaseController;
use App\Models\Requests_model;


class Requests_controller extends BaseController {

	public function index() {
        $req_model = new Requests_model();
        $requests = $req_model->get_requests();
        
        $data = [
            'requests' => $requests
        ];

        return view('User/requests', $data);
    }

    public function elivate_request_submit(){
        // handle the request
        if($this->validate([
            'username' => 'required|alpha_numeric',
            'message' => 'required'
        ])){

            $data = [
                'username' => $this->request->getPost('username'),
                'message' => $this->request->getPost('message')
            ];

            $req_model = new Requests_model();

            if($req_model->insert($data)){
                return json_encode(array("submit_response" => "success"));
                // return \redirect()->to('/profile');
            }

            return json_encode(array("submit_response" => "error"));
            // return \redirect()->to('/profile');

        }
        else{
            return json_encode(array("submit_response" => "validation_error"));
            // return \redirect()->to('/profile');
        }
    }

    public function discard_request(){
        if($this->validate([
            'username' => 'required|alpha_numeric',
        ])){

            $req_model = new Requests_model();
            
            if($req_model->discard_request($this->request->getPost('username'))){
                return json_encode(array("discard_response" => "success"));
            }

            return json_encode(array("discard_response" => "error"));

        }
        else{
            return json_encode(array("discard_response" => "validation_error"));
        }
    }

    public function approve_request(){
        if($this->validate([
            'username' => 'required|alpha_numeric',
        ])){

            $users_model = new Users_model();

            $req_model = new Requests_model();
                
            $promote = $users_model->promote_user($this->request->getPost('username'));
				
            if( $promote == FALSE )
                return \json_encode(['promote_response', 'error']);	

            if($req_model->discard_request($this->request->getPost('username'))){
                return json_encode(array("promote_response" => "success"));
            }
        }
        return json_encode(array("discard_response" => "validation_error"));

    }
    

}
