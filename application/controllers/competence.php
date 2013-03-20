<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Competence extends CI_Controller {

    public function index() {

        $userdata = $this->session->all_userdata();
        if (isset($userdata['logged_in']) && $userdata['logged_in'] == TRUE) {
            redirect('/user/affichage', 'refresh');
        } else {
            redirect('/home/login', 'refresh');
        }
    }

    public function add() {
        $userdata = $this->session->all_userdata();
        if (!isset($userdata['logged_in']) || $userdata['logged_in'] == FALSE) {
            redirect('/home/login', 'refresh');
        }
        $this->load->helper('competences_helper');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nom-compet', 'Compétence', 'required|min_length[1]');
        if ($this->form_validation->run() == FALSE) {
            redirect('/user', 'refresh');
        } else {
            $this->Competence_model->set_consultant_competence($userdata['id'], decrypt($this->input->post('nom-compet')));
            redirect('/user', 'refresh');
        }
    }

    public function update() {
        $userdata = $this->session->all_userdata();
        if (!isset($userdata['logged_in']) || $userdata['logged_in'] == FALSE) {
            redirect('/home/login', 'refresh');
        }
        $this->load->helper('competences_helper');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nom-compet-update', 'Compétence', 'required|min_length[1]');
        if ($this->form_validation->run() == FALSE) {
            redirect('/user', 'refresh');
        } else {

            $this->Competence_model->update_consultant_competence(decrypt($this->input->post('nom-compet-update')), $userdata['id']);
            redirect('/user', 'refresh');
        }
    }

    public function delete() {
        $userdata = $this->session->all_userdata();
        if (!isset($userdata['logged_in']) || $userdata['logged_in'] == FALSE) {
            redirect('/home/login', 'refresh');
        }
        $this->load->helper('competences_helper');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('compet-delete', 'Compétence', 'required|min_length[1]');
        if ($this->form_validation->run() == FALSE) {
            redirect('/user', 'refresh');
        } else {

            $this->Competence_model->delete_consultant_competence(decrypt($this->input->post('compet-delete')), $userdata['id']);
            redirect('/user', 'refresh');
        }
    }

    public function profil() {
        redirect('/user', 'refresh');
    }

    public function recherche_competences() {
        redirect('/recherche', 'refresh');
    }

    public function accueil() {
        redirect('/home', 'refresh');
    }

    public function formations() {
        redirect('/formation', 'refresh');
    }

    public function admin() {
        redirect('/admin', 'refresh');
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('/home/login', 'refresh');
    }

}

?>