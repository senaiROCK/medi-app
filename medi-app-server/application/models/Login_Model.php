<?php

class Login_Model extends CI_Model {

    public function getUserType($email, $isEmail) {
        $query = ($isEmail) ?
                $this->db->get_where('users', array('user_email_address =' => $email))->result() :
                $this->db->get_where('users', array('user_username =' => $email))->result();

        return $query[0]->user_type;
    }

    public function checkUsername($userName) {
        $query = $this->db->get_where('users', array('user_username =' => $userName))->result();

        return (sizeof($query) > 0) ? TRUE : FALSE;
    }

    public function checkEmail($email) {
        $query = $this->db->get_where('users', array('user_email_address =' => $email))->result();

        return (sizeof($query) > 0) ? TRUE : FALSE;
    }

    public function checkPassword($credentials, $isEmail) {
        $query = ($isEmail) ?
                $this->db->get_where('users', array('user_email_address =' => $credentials['user_email_address'], 'user_password =' => $credentials['user_password']))->result() :
                $this->db->get_where('users', array('user_username =' => $credentials['user_email_address'], 'user_password =' => $credentials['user_password']))->result();

        return (sizeof($query) > 0) ? TRUE : FALSE;
    }

    public function generateId() {
        $base = 16;
        $characters = 'MMadts17RbQrDGG7ddzeoGIGPC5PaKlp7WxbdpSGhf2wyMhFF+KzmFxxmwc2lbGha2TCOlZqSNnxk0xD6z1JQ==';
        $charactersLength = strlen($characters);
        $generated = date('dmYHis');
        for ($i = 0; $i < $base; $i++) {
            $generated .= $characters[rand(0, $charactersLength - 1)];
        }
        return $generated;
    }

    public function registerUser($data) {
        $this->db->insert('users', $data);
        $this->db->trans_complete();
        
        return $this->db->trans_status();
    }

}
