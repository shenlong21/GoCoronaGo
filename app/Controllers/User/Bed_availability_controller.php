<?php

namespace App\Controllers\User;

use CodeIgniter\Controller;
use App\Controllers\BaseController;
use App\Models\Activities_model;
use App\Models\Bed_availability_model;
use App\Models\Pincodes_model;


class Bed_availability_controller extends BaseController {
	
	public function index() {
		$bed_model = new Bed_availability_model();
		$details = $bed_model->get_suppliers();

		$activities_model = new Activities_model();
		$activity = $activities_model->get_bed_activities();

		$pincode_model = new Pincodes_model();
		$places = $pincode_model->places();

		$data = [
			'details' => $details,
			'activities' => $activity,
			'places' => $places
		];
		
		return view('User/bed_availability', $data);
	}


	public function bed_availability_save() {
		if($this->request->getMethod() == "post") {
			if($this->validate([
				'id' => 'required|decimal',
				'beds' => 'required|decimal',
				'bed_oxy' => 'required|decimal',
				'icu' => 'required|decimal',
				'icu_ven' => 'required|decimal',
				'verification' => 'required|in_list[0,1]'
			])){
				// \sleep(3);
				$beds_model = new Bed_availability_model();
				$id = $this->request->getPost('id');
				$verfication = $this->request->getPost('verification');
				$beds = $this->request->getPost('beds');
				$bed_oxy = $this->request->getPost('bed_oxy');
				$icu = $this->request->getPost('icu');
				$icu_ven = $this->request->getPost('icu_ven');
				$updated_at = \date_create('now');
				$updated_at_time = $updated_at->format('Y-m-d H:i:s');

				$name = $beds_model->get_name_from_id($id);

				$data = [
					'bed_available' => $beds,
					'oxygen' => $bed_oxy,
					'icu' => $icu,
					'icu_with_ventilator' => $icu_ven,
					'verification' => $verfication,
					'updated_at' => $updated_at_time
				];

				
				$update = $beds_model->update($id, $data);
				if($update){
					// adding in activity
					$activity_model = new Activities_model();
					
					$activity_model->add_activity("bed_availability", "updated", $name['name']);

					return \json_encode(array('response' => 'updated'));
				}


				return \json_encode(array('response' => 'updation error'));
			}
			else{
				return \json_encode(array('response' => 'validation error'));
			}
		}
	}


	public function add_bed_availability() {
		// $session = session();
		if($this->request->getMethod() == "post") {
			if($this->validate([
				'add_name' => 'required|alpha_numeric_punct',
				'add_address' => 'required',
				'add_description' => 'required',
				'add_phone' => 'required|decimal',
				'add_whatsapp' => 'required|decimal',
				'add_beds' => 'required|decimal',
				'add_beds_with_oxygen' => 'required|decimal',
				'add_icu' => 'required|decimal',
				'add_icu_with_ventilator' => 'required|decimal',
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
				$beds = $this->request->getPost('add_beds');
				$bed_oxy = $this->request->getPost('add_beds_with_oxygen');
				$icu = $this->request->getPost('add_icu');
				$icu_ven = $this->request->getPost('add_icu_with_ventilator');
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
					'bed_available' => $beds,
					'oxygen' => $bed_oxy,
					'icu' => $icu,
					'icu_with_ventilator' => $icu_ven,
					'pincode' => $pincode,
					'city' => $city
				];

				$beds_model = new Bed_availability_model();
				if($beds_model->insert($data)){
					
					// adding in activity
					$activity_model = new Activities_model();
					$activity_model->add_activity("bed_availability", "added", $name);

					$this->session->setFlashdata('add_response', 'inserted');
					return redirect()->to('bed_availability');
				}
				else {
					$this->session->setFlashdata('add_response', 'error');
					return redirect()->to('bed_availability');				}
			}
			$this->session->setFlashdata('add_response', 'validation_error');
			return redirect()->to('bed_availability');
		}
	}


	public function delete_bed_availability() {
		if($this->request->getMethod() == "post"){
			if(!$this->validate([
				'number' => 'required|decimal'
			])){
				$this->session->setFlashdata('del_response', 'validation_error');
				return redirect()->to('bed_availability');
			}

			$beds_model = new Bed_availability_model();
			
			$id = $this->request->getPost('number');

			$name = $beds_model->get_name_from_id($id);


			if($beds_model->check_id($id)){
				if($beds_model->delete($id)){
					
					// adding in activity
					$activity_model = new Activities_model();
					$activity_model->add_activity("bed_availability", "deleted", $name['name']);

					$this->session->setFlashdata('del_response', 'success');
					return redirect()->to('bed_availability');
				}

				// entry not deleted
				$this->session->setFlashdata('del_response', 'del_error');
				return redirect()->to('bed_availability');
				
			}

			$this->session->setFlashdata('del_response', 'del_error');
			return redirect()->to('bed_availability');
		}
	}



}
