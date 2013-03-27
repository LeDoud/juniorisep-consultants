<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Formation extends CI_Controller {

    public function index() {

        $userdata = $this->session->all_userdata();
        if (isset($userdata['logged_in']) && $userdata['logged_in'] == TRUE) {
            redirect('/formation/view', 'refresh');
        } else {
            redirect('/home/login', 'refresh');
        }
    }

    public function view() {
        $userdata = $this->session->all_userdata();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->helper('formation_helper');
        if (!isset($userdata['logged_in']) || $userdata['logged_in'] == FALSE || $userdata['role'] == 'isepien') {
            redirect('/home/login', 'refresh');
        }
        if ($userdata['first'] == TRUE) {
            redirect('/user/firstime', 'refresh');
        }
        $data['title'] = '- Espace consultant -';
        $data['menu'] = 'formation';
        $data['userdata_id'] = $userdata['id'];

        $info = $this->Formation_model->get_formation();
        $info_old = $this->Formation_model->get_formation_old();
        $data['nbr_formations'] = count($info);
        $data['nbr_formations_old'] = count($info_old);
        $data['info'] = $info;
        $data['info_old'] = $info_old;
        $this->load->view('include/header', $data);
        $this->load->view('formations', $data);
        $this->load->view('include/footer');
    }

    public function register() {
        $userdata = $this->session->all_userdata();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->helper('formation_helper');

        if (!isset($userdata['logged_in']) || $userdata['logged_in'] == FALSE || $userdata['role'] == 'isepien') {
            redirect('/home/login', 'refresh');
        }
        if ($userdata['first'] == TRUE) {
            redirect('/user/firstime', 'refresh');
        }
        $data['title'] = '- Espace consultant -';
        $data['menu'] = 'formation';
        $data['userdata_id'] = $userdata['id'];
        $this->form_validation->set_rules('formation-sign', 'Formation', 'required|min_length[1]');

        if ($this->form_validation->run() == FALSE || checkConsultant($this->input->post('formation-sign'), $userdata['id']) == TRUE) {
            $data['title'] = '- Espace consultant -';
            $data['menu'] = 'formation';

            $info = $this->Formation_model->get_formation();
            $info_old = $this->Formation_model->get_formation_old();
            $data['nbr_formations'] = count($info);
            $data['nbr_formations_old'] = count($info_old);
            $data['info'] = $info;
            $data['info_old'] = $info_old;
            $this->load->view('include/header', $data);
            $this->load->view('formations', $data);
            $this->load->view('include/footer');
        } else {
            if (count($this->Formation_model->check_consultant(decrypt($this->input->post('formation-sign')), $userdata['id'])) == 0) {
                $this->Formation_model->register_formation(decrypt($this->input->post('formation-sign')), $userdata['id']);
            }
            redirect('/formation', 'refresh');
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