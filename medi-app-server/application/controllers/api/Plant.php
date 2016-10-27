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
class Plant extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['getPlants_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['newPlant_post']['limit'] = 100; // 100 requests per hour per user/key
        // $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
    }

    public function getPlantProfile_get() {
        $plantId = $this->get('plant_id');
        $plantProfile = $this->Plant_Model->getPlantProfile($plantId);

        $this->set_response($plantProfile, REST_Controller::HTTP_CREATED);
    }

    public function getPlants_get() {
        $plants = $this->Plant_Model->getPlants();

        $this->set_response($plants, REST_Controller::HTTP_OK);
    }

    public function newPlant_post() {
        $response = FALSE;

        $plantDetails = array(
            'plant_name' => $this->post('plantName'),
            'plant_scientific_name' => $this->post('plantScientificName'),
            'plant_description' => $this->post('plantDescription'),
            'plant_pic' => $_FILES['plantPic']['name'],
            'plant_created' => date("F j, Y, g:i a")
        );

        $isExists = $this->Plant_Model->checkPlant($plantDetails['plant_name']);

        if (!$isExists) {
            $response = $this->Plant_Model->newPlant($plantDetails);
            $responseMsg = ($response) ? 'New plant successfully added.' : 'ERROR: Transaction Failed ! Try again .';
            move_uploaded_file($_FILES["plantPic"]["tmp_name"], 'assets/uploaded_images/' . $_FILES['plantPic']['name']);
        } else {
            $responseMsg = 'Plant already exists !';
        }

        $this->set_response(['status' => $response, 'response_msg' => $responseMsg], REST_Controller::HTTP_CREATED);
    }

    public function updatePlant_post() {
        $response = FALSE;

        $plantDetails = array(
            'plant_id' => $this->post('plant_id'),
            'plant_name' => $this->post('plant_name'),
            'plant_scientific_name' => $this->post('plant_scientific_name'),
            'plant_description' => $this->post('plant_description'),
            'plant_updated' => date("F j, Y, g:i a")
        );

        if (!empty($_FILES['plant_pic']['tmp_name'])) {
            $plantDetails['plant_pic'] = $_FILES['plant_pic']['name'];
            move_uploaded_file($_FILES["plant_pic"]["tmp_name"], 'assets/uploaded_images/' . $_FILES['plant_pic']['name']);
        }

        $response = $this->Plant_Model->updatePlant($plantDetails);
        $responseMsg = ($response) ? 'Plant successfully updated.' : 'ERROR: Transaction Failed ! Try again .';

        $this->set_response(['status' => $response, 'response_msg' => $responseMsg], REST_Controller::HTTP_CREATED);
    }

    public function deletePlant_get() {
        $plantId = $this->get('plant_id');

        $response = $this->Plant_Model->deletePlant($plantId);
        $responseMsg = ($response) ? 'Plant successfully deleted.' : 'ERROR : Transaction Failed ! Try again.';

        $this->set_response(['status' => $response, 'response_msg' => $responseMsg], REST_Controller::HTTP_CREATED);
    }

}
