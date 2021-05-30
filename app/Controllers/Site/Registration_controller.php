<?php
    
namespace App\Controllers\Site;

use CodeIgniter\Controller;
use App\Models\Users_model;

class Registration_controller extends Controller {

	public function check_username() {
		if($this->request->getMethod() == "post"){
			if($this->validate([
				'username' => 'required|alpha_numeric'
			])){
				$users_model = new Users_model();

				$username = $this->request->getPost('username');

				$check = $users_model->check_if_username($username);

				if($check == TRUE)
					return \json_encode(array(['response' => 'fail', 'user' => $username]));				
				else
					return \json_encode(array(['response' => 'success', 'user' => $username]));								
			}
		}		
	}


	public function check_email() {
		if($this->request->getMethod() == "post"){
			if($this->validate([
				'email' => 'required|valid_email'
			])){
				$users_model = new Users_model();

				$email = $this->request->getPost('email');

				$check = $users_model->check_if_email($email);

				if($check == TRUE)
					return \json_encode(array(['response' => 'fail', 'user' => $email]));				
				else
					return \json_encode(array(['response' => 'success', 'user' => $email]));								
			}
			else {
				return \json_encode(array(['response' => 'validation', 'user' => $email]));								

			}
		}		
	}


	public function check_phone() {
		if($this->request->getMethod() == "post"){
			if($this->validate([
				'phone' => 'required|decimal'
			])){
				$users_model = new Users_model();

				$email = $this->request->getPost('phone');

				$check = $users_model->check_if_phone($email);

				if($check == TRUE)
					return \json_encode(array(['response' => 'fail', 'user' => $email]));				
				else
					return \json_encode(array(['response' => 'success', 'user' => $email]));								
			}
			else {
				return \json_encode(array(['response' => 'validation', 'user' => $email]));								

			}
		}		
	}


	private function send_verification_email($to, $to_name, $to_username, $to_phone, $to_pass){
		// making verification link
		$secret_code = $to_phone.$to_username.$to_name;
		$hash_code = \hash("sha256",$secret_code);

		$link_code = base_url()."/verify_user/$to_username/".$hash_code;


		$message = "
			Thank you $to_name for registering on our website.<br>
			Your username : $to_username <br>
			Your password : Same as you set on the time of registration<br>
			<br>
			<br>
			Last step, <br>
			Verify your email by opening the following link - $link_code<br>
			<br>
			<br>
			<br>
			Regards,<br>
			Team Go Corona GO
		";


		$email_service = \Config\Services::email();
		$email_service->setFrom('sachinjangir0181@gmail.com', 'Go Corona Go');
		$email_service->setTo($to);
		$email_service->setSubject('Registration Successful - Go Corona Go');
		$email_service->setMessage($message);
		$email_service->send();

	}


	public function register_user() {
		if($this->request->getMethod() == "post"){
			if($this->validate([
				'username' => 'required|alpha_numeric',
				'name' => 'required',
				'email' => 'required|valid_email',
				'phone' => 'required|decimal',
				'password' => 'required|min_length[8]',
				'password_conf' => 'required|matches[password]'
			])){
				// register user
				$users_model = new Users_model();
				
				$username = $this->request->getPost('username');
				$name = $this->request->getPost('name');
				$phone = $this->request->getPost('phone');
				$email = $this->request->getPost('email');
				$password = $this->request->getPost('password');

				$password_hash = hash("sha256", $password);

				$data = [
					'username' => $username,
					'name' => $name,
					'email' => $email,
					'phone' => $phone,
					'password' => $password
				];

				if($users_model->insert($data)){
					$this->send_verification_email($email, $name, $username, $phone, $password);

					return view('Site/registration_success', ['username' => $this->request->getPost('username'), 
															  'email' => $this->request->getPost('email')]);
				}
                return view('site/error_page');
			}
			else{
				// send errors
                return view('site/error_page');
			}
		}
	}

	

	public function verify_registration_email($username = false, $code = false) {


		$users_model = new Users_model();

		// chech user exists
		if(!$users_model->check_if_username($username)){
			// echo "Invalid Link";
			return \view('/Site/registration_email_verification');
		}
		// echo "username found;";

		// make verification code
		$details = $users_model->select(['phone', 'name', 'active', 'id'])->where('username', $username)->first();

		if(!empty($details)){			

			$temp_code = $details['phone'].$username.$details['name'];			
			$temp_code_hash = hash("sha256", $temp_code);
			
			if($temp_code_hash == $code){
				if($details['active'] == 1){
					return \view('/Site/registration_email_verification', ['message' => 'done_already']);
				}
				$data = [
					'active' => 1
				];

				if($users_model->update($details['id'], $data)){
					return \view('/Site/registration_email_verification', ['message' => 'success']);
				}

				return \view('/Site/registration_email_verification', ['message' => 'error']);

			}
			return \view('/Site/registration_email_verification');
		}
		return \view('/Site/registration_email_verification');
	}
}