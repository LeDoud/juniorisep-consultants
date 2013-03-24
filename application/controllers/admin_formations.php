<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_formations extends CI_Controller {

    public function index() {

        $userdata = $this->session->all_userdata();
        if (isset($userdata['logged_in']) && $userdata['logged_in'] == TRUE) {
            redirect('/admin_formations/liste', 'refresh');
        } else {
            redirect('/home/login', 'refresh');
        }
    }

    public function liste() {
        $userdata = $this->session->all_userdata();
        $this->load->helper('form');
        $this->load->helper('formation_helper');
        $this->load->library('form_validation');
        $this->load->library('email');
        $this->load->library('upload');

        if (!isset($userdata['logged_in']) || $userdata['logged_in'] == FALSE || $userdata['role'] != 'admin') {

            redirect('/home/login', 'refresh');
        }

        $data['title'] = 'Administration';
        $data['menu'] = 'admin_formations';

        $info = $this->Formation_model->get_formation();
        $data['nbr_formations'] = count($info);
        $data['info'] = $info;

        $this->load->view('include/admin_header', $data);
        $this->load->view('admin_formations', $data);
        $this->load->view('include/footer');
    }

    public function add() {
        $userdata = $this->session->all_userdata();
        $this->load->helper('form');
        $this->load->helper('formation_helper');
        $this->load->library('form_validation');
        $this->load->library('upload');

        if (!isset($userdata['logged_in']) || $userdata['logged_in'] == FALSE || $userdata['role'] != 'admin') {

            redirect('/home/login', 'refresh');
        }

        $this->form_validation->set_message('required', 'Le champ %s est requis !');
        $this->form_validation->set_message('trim', 'Les caractères spéciaux ne sont pas accepté pour le  champ %s !');
        $this->form_validation->set_message('htmlspecialchars', 'Les caractères spéciaux ne sont pas accepté pour le  champ %s !');
        $this->form_validation->set_message('valid_email', 'Veuillez spécifier une adresse email valide pour le champ %s !');
        $this->form_validation->set_message('max_length', 'Le champ %s doit être plus court !');
        $this->form_validation->set_message('min_length', 'Le champ %s doit être plus long !');
        $this->form_validation->set_message('alpha', 'Le champ %s ne doit comporter que des lettres !');
        $this->form_validation->set_message('numeric', 'Le champ %s ne doit comporter que des chiffres !');
        $this->form_validation->set_error_delimiters('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>', '</div>');

        $this->form_validation->set_rules('nom', 'Nom de la formation', 'trim|required|min_length[4]|max_length[20]|htmlspecialchars');
        $this->form_validation->set_rules('lieu', 'Lieu de la formation', 'trim|required|min_length[3]|max_length[20]|htmlspecialchars');
        $this->form_validation->set_rules('date', 'Date de la formation', 'trim|required|htmlspecialchars');
        $this->form_validation->set_rules('intervenants', 'Intervenants de la formation', 'trim|required|min_length[3]|max_length[50]');
        $this->form_validation->set_rules('details-formation', 'Détails de la formation', 'trim|required|min_length[10]|max_length[1000]');

        if ($this->form_validation->run() == FALSE || (!$this->upload->do_upload('fichiers') && !empty($_FILES['fichiers']['name']))) {
            $data['error'] = $this->upload->display_errors('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>', '</div>');
            $info = $this->Formation_model->get_formation();
            $data['modal'] = TRUE;
            $data['nbr_formations'] = count($info);
            $data['info'] = $info;
            $data['title'] = 'Administration';
            $data['menu'] = 'admin_formations';
            $this->load->view('include/admin_header', $data);
            $this->load->view('admin_formations', $data);
            $this->load->view('include/footer');
        } else {
            $fichier = $this->upload->data();
            $nomfichier = $fichier['file_name'];
            $this->Formation_model->set_formation($nomfichier);
            redirect('/admin_formations', 'refresh');
        }
    }

    public function update() {
        $userdata = $this->session->all_userdata();
        $this->load->helper('form');
        $this->load->helper('formation_helper');
        $this->load->library('form_validation');
        $this->load->library('upload');

        if (!isset($userdata['logged_in']) || $userdata['logged_in'] == FALSE || $userdata['role'] != 'admin') {

            redirect('/home/login', 'refresh');
        }

        $this->form_validation->set_message('required', 'Le champ %s est requis !');
        $this->form_validation->set_message('trim', 'Les caractères spéciaux ne sont pas accepté pour le  champ %s !');
        $this->form_validation->set_message('htmlspecialchars', 'Les caractères spéciaux ne sont pas accepté pour le  champ %s !');
        $this->form_validation->set_message('valid_email', 'Veuillez spécifier une adresse email valide pour le champ %s !');
        $this->form_validation->set_message('max_length', 'Le champ %s doit être plus court !');
        $this->form_validation->set_message('min_length', 'Le champ %s doit être plus long !');
        $this->form_validation->set_message('alpha', 'Le champ %s ne doit comporter que des lettres !');
        $this->form_validation->set_message('numeric', 'Le champ %s ne doit comporter que des chiffres !');
        $this->form_validation->set_error_delimiters('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>', '</div>');

        $this->form_validation->set_rules('nom-update', 'Nom de la formation', 'trim|required|min_length[4]|max_length[20]|htmlspecialchars');
        $this->form_validation->set_rules('lieu-update', 'Lieu de la formation', 'trim|required|min_length[3]|max_length[20]|htmlspecialchars');
        $this->form_validation->set_rules('date-update', 'Date de la formation', 'trim|required|htmlspecialchars');
        $this->form_validation->set_rules('intervenants-update', 'Intervenants de la formation', 'trim|required|min_length[3]|max_length[50]');
        $this->form_validation->set_rules('details-formation-update', 'Détails de la formation', 'trim|required|min_length[10]|max_length[1000]');
        $this->form_validation->set_rules('id-formation-update', 'Formation', 'trim|required|min_length[1]');

        if ($this->form_validation->run() == FALSE || (!$this->upload->do_upload('fichiers-update') && !empty($_FILES['fichiers-update']['name']))) {
            $data['error'] = $this->upload->display_errors('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>', '</div>');
            $info = $this->Formation_model->get_formation();
            $data['modal2'] = TRUE;
            $data['nbr_formations'] = count($info);
            $data['info'] = $info;
            $data['title'] = 'Administration';
            $data['menu'] = 'admin_formations';
            $this->load->view('include/admin_header', $data);
            $this->load->view('admin_formations', $data);
            $this->load->view('include/footer');
        } else {
            $fichier = $this->upload->data();
            $nomfichier = $fichier['file_name'];
            $this->Formation_model->update_formation($this->input->post('id-formation-update'), $nomfichier); //$id a definir
            redirect('/admin_formations', 'refresh');
        }
    }

    public function delete() {
        $userdata = $this->session->all_userdata();
        $this->load->helper('form');
        $this->load->helper('formation_helper');
        $this->load->library('form_validation');
        $this->load->library('email');
        $this->load->library('upload');
        if (!isset($userdata['logged_in']) || $userdata['logged_in'] == FALSE || $userdata['role'] != 'admin') {

            redirect('/home/login', 'refresh');
        }

        $this->form_validation->set_rules('formation-delete', 'Formation', 'required|min_length[1]');
        if ($this->form_validation->run() == FALSE) {
            $info = $this->Formation_model->get_formation();
            $data['nbr_formations'] = count($info);
            $data['info'] = $info;
            $data['title'] = 'Administration';
            $data['menu'] = 'admin_formations';

            $this->load->view('include/admin_header', $data);
            $this->load->view('admin_formations', $data);
            $this->load->view('include/footer');
        } else {
            $this->Formation_model->delete_formation($this->input->post('formation-delete'));
            redirect('/admin_formations', 'refresh');
        }
    }

    public function admin_consultants() {
        redirect('/admin_consultants', 'refresh');
    }

    public function admin_recherches() {
        redirect('/admin_recherches', 'refresh');
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
