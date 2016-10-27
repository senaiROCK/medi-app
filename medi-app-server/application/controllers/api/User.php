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
class User extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['getUserType_get']['limit'] = 500; // 500 requests per hour per user/key
        // $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        // $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
    }
    
    public function getUsers_get() {
        $exceptId = $this->session->userId;
        $users = $this->User_Model->getUsers($exceptId);
        $this->set_response($users, REST_Controller::HTTP_OK);
    }

    public function getUserType_get() {
        $userType = $this->User_Model->getUserType($this->session->userId);
        $isAdmin = ($userType[0]->user_is_admin == 1) ? TRUE : FALSE;
        $this->set_response($isAdmin, REST_Controller::HTTP_OK);
    }

    public function getMyProfile_get() {
        $userId = $this->session->userId;
        $myProfile = $this->User_Model->getUserProfile($userId);
        $this->set_response($myProfile, REST_Controller::HTTP_OK);
    }

    public function getUserProfile_get() {
        $userId = $this->get('user_id');
        $userProfile = $this->User_Model->getUserProfile($userId);
        $this->set_response($userProfile, REST_Controller::HTTP_OK);
    }

    public function updateProfile_post() {
        $profileDetails = array(
            'user_id' => $this->post('user_id'),
            'user_username' => $this->post('user_username'),
            'user_firstname' => $this->post('user_firstname'),
            'user_lastname' => $this->post('user_lastname')
        );

        if (!empty($_FILES['user_profile_photo']['tmp_name'])) {
            $profileDetails['user_profile_photo'] = $_FILES['user_profile_photo']['name'];
            move_uploaded_file($_FILES["user_profile_photo"]["tmp_name"], 'assets/uploaded_images/' . $_FILES['user_profile_photo']['name']);
        }

        $response = $this->User_Model->updateProfile($profileDetails);
        $responseMsg = ($response) ? 'Profile successfully updated.' : 'ERROR : Transaction Failed ! Try again.';

        $this->set_response(['status' => $response, 'response_msg' => $responseMsg], REST_Controller::HTTP_CREATED);
    }

    public function addUser_post() {
        $userDetails = array(
            'user_username' => $this->post('userName'),
            'user_firstname' => $this->post('firstName'),
            'user_lastname' => $this->post('lastName'),
            'user_email_address' => $this->post('emailAddress')
        );

        if (!empty($_FILES['profilePhoto']['tmp_name'])) {
            $userDetails['user_profile_photo'] = $_FILES['profilePhoto']['name'];
            move_uploaded_file($_FILES["profilePhoto"]["tmp_name"], 'assets/uploaded_images/' . $_FILES['profilePhoto']['name']);
        }

        $response = $this->User_Model->addUser($userDetails);
        $responseMsg = ($response) ? 'New user successfully added.' : 'ERROR : Transaction Failed ! Try again.';

        $this->set_response(['status' => $response, 'response_msg' => $responseMsg], REST_Controller::HTTP_CREATED);
    }

    public function deleteUser_get() {
        $userId = $this->get('user_id');

        $response = $this->User_Model->deleteUser($userId);
        $responseMsg = ($response) ? 'User successfully deleted.' : 'ERROR : Transaction Failed ! Try again.';

        $this->set_response(['status' => $response, 'response_msg' => $responseMsg], REST_Controller::HTTP_CREATED);
    }

}
