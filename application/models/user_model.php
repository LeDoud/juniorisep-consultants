<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function get_user($login = FALSE) {
        if ($login === FALSE) {
            $this->db->from('utilisateurs');
            $this->db->order_by("firstConnect", "desc");
            $query = $this->db->get();
            return $query->result_array();
        }

        $query = $this->db->get_where('utilisateurs', array('login' => $login));
        return $query->row_array();
    }

    public function get_user_byId($id = FALSE) {
        if ($id === FALSE) {
            $this->db->from('utilisateurs');
            $this->db->order_by("firstConnect", "desc");
            $query = $this->db->get();
            return $query->result_array();
        }

        $query = $this->db->get_where('utilisateurs', array('id_consultant' => $id));
        return $query->row_array();
    }

    public function insert_user($login) {
        $data = array(
            'login' => $login,
            'nom' => '',
            'prenom' => '',
            'promotion' => '',
            'naissance' => '',
            'email' => $login . '@isep.fr',
            'tel' => '',
            'role' => 'isepien',
            'firstConnect' => date('Y-m-d H:i:s'),
            'lastConnect' => date('Y-m-d H:i:s')
        );

        return $this->db->insert('utilisateurs', $data);
    }

    public function update_user($login) {
        $data = array(
            'nom' => $this->input->post('nom'),
            'prenom' => $this->input->post('prenom'),
            'promotion' => $this->input->post('promo'),
            'naissance' => $this->input->post('naissance'),
            'email' => $this->input->post('email'),
            'tel' => $this->input->post('tel'),
            'lastConnect' => date('Y-m-d H:i:s')
        );
        $this->db->update('utilisateurs', $data, array('login' => $login));
    }

    public function update_user_role($login) {
        $data = array(
            'role' => $this->input->post('role')
        );
        $this->db->update('utilisateurs', $data, array('login' => $login));
    }

    public function update_user_lastConnect($login) {
        $data = array(
            'lastConnect' => date('Y-m-d H:i:s')
        );
        $this->db->update('utilisateurs', $data, array('login' => $login));
    }

}

?>
