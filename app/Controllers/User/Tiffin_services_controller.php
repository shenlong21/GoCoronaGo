<?php

namespace App\Controllers\User;

use CodeIgniter\Controller;
use App\Controllers\BaseController;
use App\Models\Activities_model;
use App\Models\Tiffin_service_model;

class Tiffin_services_controller extends BaseController {


	public function index() {
		$tiffin_model = new Tiffin_service_model();
		$details = $tiffin_model->get_suppliers();

		$activities_model = new Activities_model();
		$activity = $activities_model->get_tiffin_activities();

		$data = [
			'details' => $details,
			'activities' => $activity
		];
		
		return view('User/tiffin_services', $data);
	}


	public function tiffin_service_save() {
		if($this->request->getMethod() == "post") {
			if($this->validate([
				'id' => 'required|decimal',
				'verification' => 'required|in_list[0,1]'
			])){
				// \sleep(3);
				$tiffin_model = new Tiffin_service_model();
				$id = $this->request->getPost('id');
				$verfication = $this->request->getPost('verification');
				$updated_at = \date_create('now');
				$updated_at_time = $updated_at->format('Y-m-d H:i:s');

				$name = $tiffin_model->get_name_from_id($id);

				$data = [
					'verification' => $verfication,
					'updated_at' => $updated_at_time
				];

				$update = $tiffin_model->update($id, $data)	;
				if($update){
					// adding in activity
					$activity_model = new Activities_model();
					$activity_model->add_activity("tiffin_sevice", "updated",$name['name']);

					return \json_encode(array('response' => 'updated'));
				}


				return \json_encode(array('response' => 'updation error'));
			}
			else{
				return \json_encode(array('response' => 'validation error'));
			}
		}
	}


	public function add_tiffin_service() {
		// $session = session();
		if($this->request->getMethod() == "post") {
			if($this->validate([
				'add_name' => 'required|alpha_numeric_punct',
				'add_address' => 'required',
				'add_description' => 'required',
				'add_phone' => 'required|decimal',
				'add_whatsapp' => 'required|decimal',
				'add_email' => 'required|valid_email',
				'add_verification' => 'required|in_list[0,1]',
				'add_pincode' => 'required|max_length[6]',
				'add_city' => 'required|alpha_space'
			])){

				$name = $this->request->getPost('add_name');
				$address = $this->request->getPost('add_address');
				$description = $this->request->getPost('add_description');
				$phone= $this->request->getPost('add_phone');
				$whatsapp = $this->request->getPost('add_whatsapp');
				$email = $this->request->getPost('add_email');
				$verification = $this->request->getPost('add_verification');
				$pincode = $this->request->getPost('add_pincode');
				$city = $this->request->getPost('add_city');

				$data = [
					'name' => $name,
					'address' => $address,
					'description' => $description,
					'whatsapp' => $whatsapp,
					'phone' => $phone,
					'email' => $email,
					'verification' => $verification,
					'pincode' => $pincode,
					'city' => $city
				];

				$tiffin_model = new Tiffin_service_model();
				if($tiffin_model->insert($data)){
					// adding in activity
					$activity_model = new Activities_model();
					$activity_model->add_activity("tiffin_sevice", "added", $name);

					$this->session->setFlashdata('add_response', 'inserted');
					return redirect()->to('tiffin_service');
				}
				else {
					$this->session->setFlashdata('add_response', 'error');
					return redirect()->to('tiffin_service');				}
			}
			$this->session->setFlashdata('add_response', 'validation_error');
			return redirect()->to('tiffin_service');
		}
	}


	public function delete_tiffin_service() {
		if($this->request->getMethod() == "post"){
			if(!$this->validate([
				'number' => 'required|decimal'
			])){
				$this->session->setFlashdata('del_response', 'validation_error');
				return redirect()->to('tiffin_service');
			}
			
			$tiffin_model = new Tiffin_service_model();

			$id = $this->request->getPost('number');

			$name = $tiffin_model->get_name_from_id($id);


			if($tiffin_model->check_id($id)){
				if($tiffin_model->delete($id)){
					// adding in activity
					$activity_model = new Activities_model();
					$activity_model->add_activity("tiffin_sevice", "deleted", $name['name']);

					$this->session->setFlashdata('del_response', 'success');
					return redirect()->to('tiffin_service');
				}

				// entry not deleted
				$this->session->setFlashdata('del_response', 'del_error');
				return redirect()->to('tiffin_service');
				
			}

			$this->session->setFlashdata('del_response', 'del_error');
			return redirect()->to('tiffin_service');
		}
	}

}
