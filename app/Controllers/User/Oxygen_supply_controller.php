<?php

namespace App\Controllers\User;

use CodeIgniter\Controller;
use App\Controllers\BaseController;
use App\Models\Activities_model;
use App\Models\Oxygen_supply_model;
use App\Models\Pincodes_model;

class Oxygen_supply_controller extends BaseController {

	public function index() {
		$oxygen_model = new Oxygen_supply_model();
		$details = $oxygen_model->get_suppliers();

		$activities_model = new Activities_model();
		$activity = $activities_model->get_oxygen_activities();

		$pincode_model = new Pincodes_model();
		$places = $pincode_model->places();

		$data = [
			'details' => $details,
			'activities' => $activity,
			'places' => $places
		];
		
		return view('User/oxygen_supply', $data);
	}


	public function oxygen_supply_save() {
		if($this->request->getMethod() == "post") {
			if($this->validate([
				'id' => 'required|decimal',
				'oxygen_left' => 'required|in_list[-1,0,1,2,3]',
				'verification' => 'required|in_list[0,1]'
			])){
				// \sleep(3);
				$oxygen_model = new Oxygen_supply_model();
				$id = $this->request->getPost('id');
				$oxygen_left = $this->request->getPost('oxygen_left');
				$verfication = $this->request->getPost('verification');
				$updated_at = \date_create('now');
				$updated_at_time = $updated_at->format('Y-m-d H:i:s');

				$name = $oxygen_model->get_name_from_id($id);

				$data = [
					'oxygen_left' => $oxygen_left,
					'verification' => $verfication,
					'updated_at' => $updated_at_time
				];

				$update = $oxygen_model->update($id, $data)	;
				if($update){
					
					// adding in activity
					$activity_model = new Activities_model();
					$activity_model->add_activity("oxygen_supply", "updated", $name['name']);

					return \json_encode(array('response' => 'updated'));
				}


				return \json_encode(array('response' => 'updation error'));
			}
			else{
				return \json_encode(array('response' => 'validation error'));
			}
		}
	}


	public function add_oxygen_supplier() {
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
				'add_oxygen_left' => 'required|in_list[-1,0,1,2,3]',
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
				$oxygen_left = $this->request->getPost('add_oxygen_left');
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
					'oxygen_left' => $oxygen_left,
					'pincode' => $pincode,
					'city' => $city
				];

				$oxygen_model = new Oxygen_supply_model();
				if($oxygen_model->insert($data)){
					
					// adding in activity
					$activity_model = new Activities_model();
					$activity_model->add_activity("oxygen_supply", "added", $name);

					$this->session->setFlashdata('add_response', 'inserted', $name);
					return redirect()->to('oxygen_supply');
				}
				else {
					$this->session->setFlashdata('add_response', 'error');
					return redirect()->to('oxygen_supply');				}
			}
			$session->setFlashdata('add_response', 'validation_error');
			return redirect()->to('oxygen_supply');
		}
	}


	public function delete_oxygen_supply() {
		if($this->request->getMethod() == "post"){
			if(!$this->validate([
				'number' => 'required|decimal'
			])){
				$this->session->setFlashdata('del_response', 'validation_error');
				return redirect()->to('oxygen_supply');
			}

			$oxygen_model = new Oxygen_supply_model();
			
			$id = $this->request->getPost('number');

			$name = $oxygen_model->get_name_from_id($id);

			if($oxygen_model->check_id($id)){
				if($oxygen_model->delete($id)){

					// adding in activity
					$activity_model = new Activities_model();
					$activity_model->add_activity("oxygen_supply", "deleted", $name['name']);

					$this->session->setFlashdata('del_response', 'success');
					return redirect()->to('oxygen_supply');
				}

				// entry not deleted
				$this->session->setFlashdata('del_response', 'del_error');
				return redirect()->to('oxygen_supply');
				
			}

			$this->session->setFlashdata('del_response', 'del_error');
			return redirect()->to('oxygen_supply');
		}
	}

}
