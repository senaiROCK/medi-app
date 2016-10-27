<?php

require APPPATH . '/libraries/REST_Controller.php';

class Registration extends REST_Controller {

	public function registerUser_post() {

		$data = array(
			'user_username' => $this->post('userName'),
			'user_email_address' => $this->post('email'),
			'user_password' => $this->post('password')
		);

		$response = $this->Login_Model->registerUser($data);
		$responseMsg = ($response) ? 'You are succesfully registered.' : 'ERROR : Transaction Failed ! Try again';

        $this->set_response(['status' => $response, 'response_msg' => $responseMsg], REST_Controller::HTTP_OK);
	}

}