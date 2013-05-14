<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Stage extends CI_Controller {

    public function index() {

        $userdata = $this->session->all_userdata();
        if (isset($userdata['logged_in']) && $userdata['logged_in'] == TRUE) {
            redirect('/stage/view', 'refresh');
        } else {
            redirect('/home/login', 'refresh');
        }
    }

    public function view() {
        $this->load->helper('stage_helper');
        $userdata = $this->session->all_userdata();
        if (!isset($userdata['logged_in']) || $userdata['logged_in'] == FALSE) {
            redirect('/home/login', 'refresh');
        }
        if ($userdata['first'] == TRUE) {
            redirect('/user/firstime', 'refresh');
        }
        $data['title'] = '- Espace consultant -';
        $data['menu'] = 'stage';
        $data['role'] = $userdata['role'];
        $data['userdata_id'] = $userdata['id'];

        $info = $this->Stage_model->get_stage();
        $data['nbr_stages'] = count($info);
        $data['info'] = $info;


        $this->load->view('include/header', $data);
        $this->load->view('stages', $data);
        $this->load->view('include/footer');
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
