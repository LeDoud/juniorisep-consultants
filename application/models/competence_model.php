<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Competence_model extends CI_Model { // pour le consultant

    public function __construct() {
        $this->load->database();
    }

    public function get_competence_all($id=FALSE) {
        if ($id === FALSE) {
            $this->db->order_by("nom_competence", "asc");
            $query = $this->db->get('competences');
            return $query->result_array();
        }

        $query = $this->db->get_where('competences', array('id_competence' => $id));
        return $query->row_array();
    }

    public function get_competence($id=FALSE) {
        if ($id === FALSE) {
            $this->db->order_by("nom_competence", "asc");
            $query = $this->db->get_where('competences', array('categorie !=' => '0'));
            return $query->result_array();
        }

        $query = $this->db->get_where('competences', array('id_competence' => $id, 'categorie !=' => '0'));
        return $query->row_array();
    }

    public function get_categorie($id=FALSE) {
        if ($id === FALSE) {
            $this->db->order_by("nom_competence", "asc");
            $query = $this->db->get_where('competences', array('categorie' => '0'));
            return $query->result_array();
        }

        $query = $this->db->get_where('competences', array('id_competence' => $id, 'categorie' => '0'));
        return $query->row_array();
    }

    public function set_competence() {
        $data = array(
            'nom_competence' => $this->input->post('nom'),
            'categorie' => $this->input->post('categorie')
        );

        return $this->db->insert('competences', $data);
    }

    public function update_competence($id) {
        $data = array(
            'nom' => $this->input->post('nom_competence'),
            'prenom' => $this->input->post('categorie')
        );
        $this->db->update('competences', $data, array('id_competence' => $id));
    }

    public function set_consultant_competence($id, $compet) {
        $data = array(
            'id_consultant' => $id,
            'id_competence' => $compet,
            'niveau' => $this->input->post('lvl-compet')
        );

        return $this->db->insert('competences_eleves', $data);
    }

    public function get_consultant_competence($id_consultant) {
        $query = $this->db->get_where('competences_eleves', array('id_consultant' => $id_consultant));
        return $query->result_array();
    }

    public function update_consultant_competence($id_compet, $id_consultant) {
        $data = array(
            'niveau' => $this->input->post('lvl-compet-update')
        );
        $this->db->update('competences_eleves', $data, array('id_competences_eleves' => $id_compet, 'id_consultant' => $id_consultant));
    }

    public function check_consultant($id, $id_consultant) {
        $this->db->from('competences_eleves');
        $this->db->where('id_competence', $id);
        $this->db->where('id_consultant', $id_consultant);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function delete_consultant_competence($id_compet, $id_consultant) {
        $this->db->delete('competences_eleves', array('id_competences_eleves' => $id_compet, 'id_consultant' => $id_consultant));
    }

}

?>