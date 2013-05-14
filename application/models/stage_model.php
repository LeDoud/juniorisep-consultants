<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Stage_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function get_stage($id=FALSE) {
        if ($id === FALSE) {
            $this->db->from('stage');
            $this->db->where('dispo', 'oui');
            $this->db->order_by("date", "desc");
            $query = $this->db->get();
            return $query->result_array();
        }

        $query = $this->db->get_where('stage', array('id_stage' => $id));
        return $query->row_array();
    }

    public function get_stage_all($id=FALSE) {
        if ($id === FALSE) {
            $this->db->from('stage');
            $this->db->order_by("date", "desc");
            $query = $this->db->get();
            return $query->result_array();
        }

        $query = $this->db->get_where('stage', array('id_stage' => $id));
        return $query->row_array();
    }


    public function set_stage($nomfichier='') {
        $data = array(
            'societe' => $this->input->post('societe'),
            'poste' => $this->input->post('poste'),
            'competences' => $this->input->post('competences'),
            'duree' => $this->input->post('duree'),
            'details_stage' => $this->input->post('details_stage'),
            'date' => date('Y-m-d H:i:s'),
            'dispo' => 'oui',
            'fichiers' => $nomfichier
        );

        return $this->db->insert('stage', $data);
    }

    public function update_stage($id, $nomfichier='') {
        $data = array(
            'societe' => $this->input->post('societe-update'),
            'poste' => $this->input->post('poste-update'),
            'competences' => $this->input->post('competences-update'),
            'duree' => $this->input->post('duree-update'),
            'details_stage' => $this->input->post('details_stage-update'),
            'date' => date('Y-m-d H:i:s'),
            'fichiers' => $nomfichier
        );
        $this->db->update('stage', $data, array('id_stage' => $id));
    }

    public function delete_stage($id) {
        $this->db->delete('stage', array('id_stage' => $id));
    }

    public function update_stage_dispo($id) {
        $data = array(
            'dispo' => $this->input->post('dispo'),
        );
        $this->db->update('stage', $data, array('id_stage' => $id));
    }

}

?>