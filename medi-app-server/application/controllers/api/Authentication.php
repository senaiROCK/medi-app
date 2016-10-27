<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Authentication extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['checkUser_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['authenticateUser_get']['limit'] = 500; // 500 requests per hour per user/key
        // $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        // $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
    }

    public function checkUser_get() {

        $loginCredentials = array(
            'user_email_address' => $this->get('user_name')
        );

        $isEmail = (filter_var($loginCredentials['user_email_address'], FILTER_VALIDATE_EMAIL)) ? TRUE : FALSE;

        if ($isEmail) {
            filter_var($loginCredentials['user_email_address'], FILTER_SANITIZE_EMAIL);
        }

        $response = ($isEmail) ? $this->Login_Model->checkEmail($loginCredentials['user_email_address']) : $this->Login_Model->checkUsername($loginCredentials['user_email_address']);
        $responseMsg = ($response) ? '' : 'Unrecognized user !';

        $this->set_response(['status' => $response, 'response_msg' => $responseMsg], REST_Controller::HTTP_OK);
    }

    public function authenticateUser_get() {
        $loginCredentials = array(
            'user_email_address' => $this->get('user_name'),
            'user_password' => $this->get('password')
        );

        $userType = NULL;

        $isEmail = (filter_var($loginCredentials['user_email_address'], FILTER_VALIDATE_EMAIL)) ? TRUE : FALSE;

        if ($isEmail) {
            filter_var($loginCredentials['user_email_address'], FILTER_SANITIZE_EMAIL);
        }

        $isExists = ($isEmail) ? $this->Login_Model->checkEmail($loginCredentials['user_email_address']) : $this->Login_Model->checkUsername($loginCredentials['user_email_address']);
        $response = ($isExists) ? $this->Login_Model->checkPassword($loginCredentials, $isEmail) : FALSE;
        $responseMsg = ($response) ? '' : 'Wrong password ! Try again.';

        if ($response) {
            $user = $this->User_Model->getUserByEmail($loginCredentials['user_email_address'], $isEmail);

            // set session
            $this->session->set_userdata(
                    array(
                        'isAuthorized' => TRUE,
                        'userId' => $user[0]->user_id,
                        'isAdmin' => $user[0]->user_is_admin
            ));
        }

        $this->set_response(['status' => $response, 'response_msg' => $responseMsg], REST_Controller::HTTP_OK);
    }

    public function endSession_post() {
        $this->session->sess_destroy();
    }

}
