<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function index() {

        $userdata = $this->session->all_userdata();
        if (isset($userdata['logged_in']) && $userdata['logged_in'] == TRUE) {
            redirect('/admin/accueil', 'refresh');
        } else {
            redirect('/home/login', 'refresh');
        }
    }

    public function accueil() {
        $userdata = $this->session->all_userdata();
        if (!isset($userdata['logged_in']) || $userdata['logged_in'] == FALSE || $userdata['role'] != 'admin') {

            redirect('/home/login', 'refresh');
        }

        $data['title'] = 'Administration';
        $data['message'] = ' Bienvenue sur l’interface d’administration ! ';
        $data['menu'] = 'admin';
        $this->load->view('include/admin_header', $data);
        $this->load->view('admin', $data);
        $this->load->view('include/footer');
    }

    public function admin_consultants() {
        redirect('/admin_consultants', 'refresh');
    }

    public function admin_recherches() {
        redirect('/admin_recherches', 'refresh');
    }

    public function admin_formations() {
        redirect('/admin_formations', 'refresh');
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('/home/login', 'refresh');
    }

}

?>
