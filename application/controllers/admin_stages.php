<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_stages extends CI_Controller {

    public function index() {

        $userdata = $this->session->all_userdata();
        if (isset($userdata['logged_in']) && $userdata['logged_in'] == TRUE) {
            redirect('/admin_stages/liste', 'refresh');
        } else {
            redirect('/home/login', 'refresh');
        }
    }

    public function liste() {
        $userdata = $this->session->all_userdata();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->helper('stage_helper');
        if (!isset($userdata['logged_in']) || $userdata['logged_in'] == FALSE || $userdata['role'] != 'admin') {

            redirect('/home/login', 'refresh');
        }

        $data['title'] = 'Administration';
        $data['menu'] = 'admin_stages';


        $info = $this->Stage_model->get_stage_all();
        $data['nbr_stages'] = count($info);
        $data['info'] = $info;
        $this->load->view('include/admin_header', $data);
        $this->load->view('admin_stages', $data);
        $this->load->view('include/footer');
    }

    public function change() {
        $userdata = $this->session->all_userdata();
        if (!isset($userdata['logged_in']) || $userdata['logged_in'] == FALSE || $userdata['role'] != 'admin') {

            redirect('/home/login', 'refresh');
        }
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('dispo', 'Disponibilité', 'trim|required|htmlspecialchars');
        $this->form_validation->set_rules('thisstage', 'Stage', 'trim|required|htmlspecialchars');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Administration';
            $data['menu'] = 'admin_stages';


            $info = $this->Stage_model->get_stage_all();
            $data['nbr_stages'] = count($info);
            $data['info'] = $info;
            $this->load->view('include/admin_header', $data);
            $this->load->view('admin_stages', $data);
            $this->load->view('include/footer');
        } else {
            $this->Stage_model->update_stage_dispo($this->input->post('thisstage'));
            redirect('/admin_stages', 'refresh');
        }
    }

    public function add() {
        $userdata = $this->session->all_userdata();
        $this->load->helper('form');
        $this->load->helper('stage_helper');
        $this->load->library('form_validation');
        $this->load->library('email');
        $this->load->library('upload');

        if (!isset($userdata['logged_in']) || $userdata['logged_in'] == FALSE || $userdata['role'] != 'admin') {

            redirect('/home/login', 'refresh');
        }

        $this->form_validation->set_message('required', 'Le champ %s est requis !');
        $this->form_validation->set_message('trim', 'Les caractères spéciaux ne sont pas accepté pour le  champ %s !');
        $this->form_validation->set_message('htmlspecialchars', 'Les caractères spéciaux ne sont pas acceptés pour le  champ %s !');
        $this->form_validation->set_message('valid_email', 'Veuillez spécifier une adresse email valide pour le champ %s !');
        $this->form_validation->set_message('max_length', 'Le champ %s doit être plus court !');
        $this->form_validation->set_message('min_length', 'Le champ %s doit être plus long !');
        $this->form_validation->set_message('alpha', 'Le champ %s ne doit comporter que des lettres !');
        $this->form_validation->set_message('numeric', 'Le champ %s ne doit comporter que des chiffres !');
        $this->form_validation->set_error_delimiters('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>', '</div>');

        $this->form_validation->set_rules('societe', 'Société', 'trim|required|htmlspecialchars');
        $this->form_validation->set_rules('competences', 'Compétences', 'trim|required|min_length[2]|max_length[50]|htmlspecialchars');
        $this->form_validation->set_rules('poste', 'Poste', 'trim|required|htmlspecialchars');
        $this->form_validation->set_rules('duree', 'Durée de stage', 'trim|required');
        $this->form_validation->set_rules('details_stage', 'Détails du stage', 'required|min_length[10]|max_length[1000]');

        if ($this->form_validation->run() == FALSE || (!$this->upload->do_upload('fichiers') && !empty($_FILES['fichiers']['name']))) {
            $data['error'] = $this->upload->display_errors('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>', '</div>');
            $info = $this->Stage_model->get_stage_all();
            $data['modal'] = TRUE;
            $data['nbr_stages'] = count($info);
            $data['info'] = $info;
            $data['title'] = 'Administration';
            $data['menu'] = 'admin_stages';
            $this->load->view('include/admin_header', $data);
            $this->load->view('admin_stages', $data);
            $this->load->view('include/footer');
        } else {
            $fichier = $this->upload->data();
            $nomfichier = $fichier['file_name'];
            $this->Stage_model->set_stage($nomfichier);
            redirect('/admin_stages', 'refresh');
        }
    }

    public function update() {
        $userdata = $this->session->all_userdata();
        $this->load->helper('form');
        $this->load->helper('stage_helper');
        $this->load->library('form_validation');
        $this->load->library('email');
        $this->load->library('upload');

        if (!isset($userdata['logged_in']) || $userdata['logged_in'] == FALSE || $userdata['role'] != 'admin') {

            redirect('/home/login', 'refresh');
        }

        $this->form_validation->set_message('required', 'Le champ %s est requis !');
        $this->form_validation->set_message('trim', 'Les caractères spéciaux ne sont pas acceptés pour le  champ %s !');
        $this->form_validation->set_message('htmlspecialchars', 'Les caractères spéciaux ne sont pas accepté pour le  champ %s !');
        $this->form_validation->set_message('valid_email', 'Veuillez spécifier une adresse email valide pour le champ %s !');
        $this->form_validation->set_message('max_length', 'Le champ %s doit être plus court !');
        $this->form_validation->set_message('min_length', 'Le champ %s doit être plus long !');
        $this->form_validation->set_message('alpha', 'Le champ %s ne doit comporter que des lettres !');
        $this->form_validation->set_message('numeric', 'Le champ %s ne doit comporter que des chiffres !');
        $this->form_validation->set_error_delimiters('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>', '</div>');

       
        $this->form_validation->set_rules('societe-update', 'Société', 'trim|required|htmlspecialchars');
        $this->form_validation->set_rules('competences-update', 'Compétences', 'trim|required|min_length[2]|max_length[50]|htmlspecialchars');
        $this->form_validation->set_rules('poste-update', 'Poste', 'trim|required|htmlspecialchars');
        $this->form_validation->set_rules('duree-update', 'Durée de stage', 'trim|required');
        $this->form_validation->set_rules('details_stage-update', 'Détails du stage', 'required|min_length[10]|max_length[1000]');
        $this->form_validation->set_rules('id-stage-update', 'Offre de stage', 'trim|required|min_length[1]');

        if ($this->form_validation->run() == FALSE || (!$this->upload->do_upload('fichiers-update') && !empty($_FILES['fichiers-update']['name']))) {
            $data['error'] = $this->upload->display_errors('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>', '</div>');
            $info = $this->Stage_model->get_stage_all();
            $data['modal2'] = TRUE;
            $data['nbr_stages'] = count($info);
            $data['info'] = $info;
            $data['title'] = 'Administration';
            $data['menu'] = 'admin_stages';
            $this->load->view('include/admin_header', $data);
            $this->load->view('admin_stages', $data);
            $this->load->view('include/footer');
        } else {
            $fichier = $this->upload->data();
            $nomfichier = $fichier['file_name'];
            $this->Stage_model->update_stage($this->input->post('id-stage-update'), $nomfichier);
            redirect('/admin_stages', 'refresh');
        }
    }

    public function delete() {
        $userdata = $this->session->all_userdata();
        $this->load->helper('form');
        $this->load->helper('stage_helper');
        $this->load->library('form_validation');
        $this->load->library('email');
        $this->load->library('upload');
        if (!isset($userdata['logged_in']) || $userdata['logged_in'] == FALSE || $userdata['role'] != 'admin') {

            redirect('/home/login', 'refresh');
        }

        $this->form_validation->set_rules('stage-delete', 'Offre de stage', 'required|min_length[1]');
        if ($this->form_validation->run() == FALSE) {
            $info = $this->Stage_model->get_stage_all();
            $data['nbr_stages'] = count($info);
            $data['info'] = $info;
            $data['title'] = 'Administration';
            $data['menu'] = 'admin_stages';

            $this->load->view('include/admin_header', $data);
            $this->load->view('admin_stages', $data);
            $this->load->view('include/footer');
        } else {
            $this->Stage_model->delete_stage($this->input->post('stage-delete'));
            redirect('/admin_stages', 'refresh');
        }
    }

    public function admin_consultants() {
        redirect('/admin_consultants', 'refresh');
    }

    public function admin() {
        redirect('/admin', 'refresh');
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
