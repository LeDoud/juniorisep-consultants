<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Recherche_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function get_recherche($id=FALSE) {
        if ($id === FALSE) {
            $this->db->from('recherche_competences');
            $this->db->where('dispo', 'oui');
            $this->db->order_by("date", "desc");
            $query = $this->db->get();
            return $query->result_array();
        }

        $query = $this->db->get_where('recherche_competences', array('id_recherche' => $id));
        return $query->row_array();
    }

    public function get_recherche_all($id=FALSE) {
        if ($id === FALSE) {
            $this->db->from('recherche_competences');
            $this->db->order_by("date", "desc");
            $query = $this->db->get();
            return $query->result_array();
        }

        $query = $this->db->get_where('recherche_competences', array('id_recherche' => $id));
        return $query->row_array();
    }

    public function get_consultants_recherche($id) {

        $query = $this->db->get_where('recherche_competences_eleves', array('id_recherche' => $id));
        return $query->result_array();
    }

    public function check_consultant($id, $id_consultant) {
        $this->db->from('recherche_competences_eleves');
        $this->db->where('id_recherche', $id);
        $this->db->where('id_consultant', $id_consultant);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function set_recherche($nomfichier='', $id_cdp) {
        $data = array(
            'nom_mission' => $this->input->post('nom_mission'),
            'priorite' => $this->input->post('priorite'),
            'type' => $this->input->post('type'),
            'competences' => $this->input->post('competences'),
            'difficulte' => $this->input->post('difficulte'),
            'nbr_intervenants' => $this->input->post('nbr_intervenants'),
            'details_recherche' => $this->input->post('details_recherche'),
            'date' => date('Y-m-d H:i:s'),
            'fichiers' => $nomfichier,
            'dispo' => 'oui',
            'id_cdp' => $id_cdp
        );

        return $this->db->insert('recherche_competences', $data);
    }

    public function update_recherche($id, $id_cdp, $nomfichier='') {
        $data = array(
            'nom_mission' => $this->input->post('nom_mission'),
            'priorite' => $this->input->post('priorite'),
            'type' => $this->input->post('type'),
            'competences' => $this->input->post('competences'),
            'difficulte' => $this->input->post('difficulte'),
            'nbr_intervenants' => $this->input->post('nbr_intervenants'),
            'details_recherche' => $this->input->post('details_recherche'),
            'date' => date('Y-m-d H:i:s'),
            'fichiers' => $nomfichier,
            'dispo' => $this->input->post('dispo'),
            'id_cdp' => $id_cdp
        );
        $this->db->update('recherche_competences', $data, array('id_recherche' => $id));
    }

    public function delete_recherche($id) {
        $this->db->delete('recherche_competences', array('id_recherche' => $id));
    }

    public function postulate_recherche($id_recherche, $id_consultant) {
        $data = array(
            'id_recherche' => $id_recherche,
            'id_consultant' => $id_consultant,
            'date' => date('Y-m-d H:i:s')
        );

        return $this->db->insert('recherche_competences_eleves', $data);
    }

    public function update_recherche_dispo($id) {
        $data = array(
            'dispo' => $this->input->post('dispo'),
        );
        $this->db->update('recherche_competences', $data, array('id_recherche' => $id));
    }

}

?>