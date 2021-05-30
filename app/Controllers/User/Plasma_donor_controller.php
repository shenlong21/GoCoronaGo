<?php

namespace App\Controllers\User;

use CodeIgniter\Controller;
use App\Controllers\BaseController;
use App\Models\Activities_model;
use App\Models\Plasma_donor_model;
use App\Models\Pincodes_model;

class Plasma_donor_controller extends BaseController {

	public function index() {
		$donor_model = new Plasma_donor_model();
		$details = $donor_model->get_plasma_donors();

		$activities_model = new Activities_model();
		$activity = $activities_model->get_plasma_activities();

		$pincode_model = new Pincodes_model();
		$places = $pincode_model->places();

		$data = [
			'details' => $details,
			'activities' => $activity,
			'places' => $places
		];
		
		return view('User/plasma_donor', $data);
	}


	public function plasma_donor_save() {
		if($this->request->getMethod() == "post") {
			if($this->validate([
				'id' => 'required|decimal',
				'verification' => 'required|in_list[0,1]'
			])){
				// \sleep(3);
				$donor_model = new Plasma_donor_model();
				$id = $this->request->getPost('id');
				$verfication = $this->request->getPost('verification');
				$updated_at = \date_create('now');
				$updated_at_time = $updated_at->format('Y-m-d H:i:s');

				$name = $donor_model->get_name_from_id($id);

				$data = [
					'verification' => $verfication,
					'updated_at' => $updated_at_time
				];

				$update = $donor_model->update($id, $data)	;
				if($update){

					// adding in activity
					$activity_model = new Activities_model();
					$activity_model->add_activity("plasma_donor", "updated", $name['name']);

					return \json_encode(array('response' => 'updated'));
				}


				return \json_encode(array('response' => 'updation error'));
			}
			else{
				return \json_encode(array('response' => 'validation error'));
			}
		}
	}


	public function add_plasma_donor() {
		// $session = session();
		if($this->request->getMethod() == "post") {
			if($this->validate([
				'add_name' => 'required|alpha_numeric_punct',
				'add_phone' => 'required|decimal',
				'add_whatsapp' => 'required|decimal',
				'add_age' => 'required|decimal',
				'add_verification' => 'required|in_list[0,1]',
				'add_pincode' => 'required|max_length[6]',
				'add_city' => 'required|alpha_space'
			])){

				$name = $this->request->getPost('add_name');
				$phone= $this->request->getPost('add_phone');
				$whatsapp = $this->request->getPost('add_whatsapp');
				$age = $this->request->getPost('add_age');
				$verification = $this->request->getPost('add_verification');
				$pincode = $this->request->getPost('add_pincode');
				$city = $this->request->getPost('add_city');

				$data = [
					'name' => $name,
					'phone' => $phone,
					'whatsapp' => $whatsapp,
					'age' => $age,
					'verification' => $verification,
					'pincode' => $pincode,
					'city' => $city
				];

				$donor_model = new Plasma_donor_model();
				if($donor_model->insert($data)){
					
					// adding in activity
					$activity_model = new Activities_model();
					$activity_model->add_activity("plasma_donor", "added", $name);

					$this->session->setFlashdata('add_response', 'inserted');
					return redirect()->to('plasma_donors');
				}
				else {
					$this->session->setFlashdata('add_response', 'error');
					return redirect()->to('plasma_donors');				}
			}
			$session->setFlashdata('add_response', 'validation_error');
			return redirect()->to('plasma_donors');
		}
	}


	public function delete_plasma_donor() {
		if($this->request->getMethod() == "post"){
			if(!$this->validate([
				'number' => 'required|decimal'
			])){
				$this->session->setFlashdata('del_response', 'validation_error');
				return redirect()->to('oxygen_supply');
			}
			
			$donor_model = new Plasma_donor_model();
			
			$id = $this->request->getPost('number');

			$name = $donor_model->get_name_from_id($id);

			if($donor_model->check_id($id)){
				if($donor_model->delete($id)){
					
					// adding in activity
					$activity_model = new Activities_model();
					$activity_model->add_activity("plasma_donor", "deleted", $name['name']);

					$this->session->setFlashdata('del_response', 'success');
					return redirect()->to('plasma_donors');
				}

				// entry not deleted
				$this->session->setFlashdata('del_response', 'del_error');
				return redirect()->to('plasma_donors');
				
			}

			$this->session->setFlashdata('del_response', 'del_error');
			return redirect()->to('plasma_donors');
		}
	}

}
