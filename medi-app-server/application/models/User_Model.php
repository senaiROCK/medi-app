<?php

class User_Model extends CI_Model {
    
    public function getUsers($exceptId) {
        return $this->db->get_where('users', array('user_id !=' => $exceptId))->result();
    }

    public function getUserByEmail($email, $isEmail) {
        return ($isEmail) ?
                $this->db->get_where('users', array('user_email_address =' => $email))->result() :
                $this->db->get_where('users', array('user_username =' => $email))->result();
    }

    public function getUserType($userId) {
        $this->db->where('user_id', $userId);
        return $this->db->select('user_is_admin')->from('users')->get()->result();
    }

    public function getUserProfile($userId) {
        return $this->db->query('SELECT * FROM users WHERE user_id = ' . $userId . '')->result()[0];
    }

    public function updateProfile($profileDetails) {
        $this->db->where('user_id', $profileDetails['user_id']);
        $this->db->update('users', $profileDetails);
        $this->db->trans_complete();
        
        return $this->db->trans_status();
    }

    public function addUser($userDetails) {
        $this->db->insert('users', $userDetails);
        $this->db->trans_complete();
        
        return $this->db->trans_status();
    }

    public function deleteUser($userId) {
        $this->db->where('user_id', $userId);
        $this->db->delete('users');
        $this->db->trans_complete();
        
        return $this->db->trans_status();
    }

}
