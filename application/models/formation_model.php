<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Formation_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function get_formation($id = FALSE) {
        if ($id === FALSE) {
            //$query = $this->db->get('formations');
            $this->db->from('formations');
            $this->db->order_by("date", "desc");
            $query = $this->db->get();
            return $query->result_array();
        }

        $query = $this->db->get_where('formations', array('id_formation' => $id));
        return $query->row_array();
    }

    public function get_consultants_formation($id) {

        $query = $this->db->get_where('formations_eleves', array('id_formation' => $id));
        return $query->result_array();
    }

    public function check_consultant($id, $id_consultant) {
        $this->db->from('formations_eleves');
        $this->db->where('id_formation', $id);
        $this->db->where('id_consultant', $id_consultant);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function set_formation($nomfichier='') {
        $data = array(
            'nom_formation' => $this->input->post('nom'),
            'lieu' => $this->input->post('lieu'),
            'date' => $this->input->post('date'),
            'intervenants' => $this->input->post('intervenants'),
            'details_formation' => $this->input->post('details-formation'),
            'fichiers' => $nomfichier
        );

        return $this->db->insert('formations', $data);
    }

    public function update_formation($id) {
        $data = array(
            'nom_formation' => $this->input->post('nom'),
            'lieu' => $this->input->post('lieu'),
            'date' => $this->input->post('date'),
            'intervenants' => $this->input->post('intervenants'),
            'details_formation' => $this->input->post('details-formation'),
            'fichiers' => $nomfichier
        );
        $this->db->update('formations', $data, array('id_formation' => $id));
    }

    public function delete_formation($id) {
        $this->db->delete('formations', array('id_formation' => $id));
    }

    public function register_formation($id_formation, $id_consultant) {
        $data = array(
            'id_formation' => $id_formation,
            'id_consultant' => $id_consultant,
            'date' => date('Y-m-d H:i:s')
        );

        return $this->db->insert('formations_eleves', $data);
    }

}

?>