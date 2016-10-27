<?php

class Plant_Model extends CI_Model {

    public function getPlants() {
        return $this->db->get('plants')->result();
    }
    
    public function getPlantProfile($plantId) {
        return $this->db->get_where('plants', array('plant_id =' => $plantId))->result()[0];
    }

    public function checkPlant($plantName) {
        $query = $this->db->get_where('plants', array('plant_name =' => $plantName))->result();

        return (sizeof($query) > 0) ? TRUE : FALSE;
    }
    
    public function newPlant($plantDetails) {
        $this->db->insert('plants', $plantDetails);
        $this->db->trans_complete();
        
        return $this->db->trans_status();
    }

    public function updatePlant($plantDetails) {
        $this->db->where('plant_id', $plantDetails['plant_id']);
        $this->db->update('plants', $plantDetails);
        $this->db->trans_complete();
        
        return $this->db->trans_status();
    }

    public function deletePlant($plantId) {
        $this->db->where('plant_id', $plantId);
        $this->db->delete('plants');
        $this->db->trans_complete();
        
        return $this->db->trans_status();
    }

}
