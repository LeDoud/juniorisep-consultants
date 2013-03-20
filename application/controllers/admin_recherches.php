<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_recherches extends CI_Controller {

    public function index() {

        $userdata = $this->session->all_userdata();
        if (isset($userdata['logged_in']) && $userdata['logged_in'] == TRUE) {
            redirect('/admin_recherches/liste', 'refresh');
        } else {
            redirect('/home/login', 'refresh');
        }
    }

    public function liste() {
        $userdata = $this->session->all_userdata();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->helper('recherche_helper');
        if (!isset($userdata['logged_in']) || $userdata['logged_in'] == FALSE || $userdata['role'] != 'admin') {

            redirect('/home/login', 'refresh');
        }

        $data['title'] = 'Administration';
        $data['menu'] = 'admin_recherches';


        $info = $this->Recherche_model->get_recherche_all();
        $data['nbr_recherches'] = count($info);
        $data['info'] = $info;
        $this->load->view('include/admin_header', $data);
        $this->load->view('admin_recherches', $data);
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
        $this->form_validation->set_rules('thisrecherche', 'Mission', 'trim|required|htmlspecialchars');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Administration';
            $data['menu'] = 'admin_recherches';


            $info = $this->Recherche_model->get_recherche_all();
            $data['nbr_recherches'] = count($info);
            $data['info'] = $info;
            $this->load->view('include/admin_header', $data);
            $this->load->view('admin_recherches', $data);
            $this->load->view('include/footer');
        } else {
            $this->Recherche_model->update_recherche_dispo($this->input->post('thisrecherche'));
            redirect('/admin_recherches', 'refresh');
        }
    }

    public function add() {
        $userdata = $this->session->all_userdata();
        $this->load->helper('form');
        $this->load->helper('recherche_helper');
        $this->load->library('form_validation');
        $this->load->library('email');
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

        $this->form_validation->set_rules('nom_mission', 'Nom de la mission', 'trim|required|min_length[4]|max_length[25]|htmlspecialchars');
        $this->form_validation->set_rules('type', 'Type de mission', 'trim|required|min_length[4]|max_length[25]|htmlspecialchars');
        $this->form_validation->set_rules('competences', 'Compétences requises', 'trim|required|min_length[2]|max_length[50]|htmlspecialchars');
        $this->form_validation->set_rules('priorite', 'Priorité', 'trim|required|htmlspecialchars');
        $this->form_validation->set_rules('difficulte', 'Difficulté', 'trim|required|htmlspecialchars');
        $this->form_validation->set_rules('nbr_intervenants', 'Nombre de consultants requis', 'trim|required');
        $this->form_validation->set_rules('details_recherche', 'Détails de la mission', 'required|min_length[10]|max_length[250]');
//+email  pour dire de faire de la pub
        if ($this->form_validation->run() == FALSE || (!$this->upload->do_upload('fichiers') && !empty($_FILES['fichiers']['name']))) {
            $data['error'] = $this->upload->display_errors('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>', '</div>');
            $info = $this->Recherche_model->get_recherche_all();
            $data['modal'] = TRUE;
            $data['nbr_recherches'] = count($info);
            $data['info'] = $info;
            $data['title'] = 'Administration';
            $data['menu'] = 'admin_recherches';
            $this->load->view('include/admin_header', $data);
            $this->load->view('admin_recherches', $data);
            $this->load->view('include/footer');
        } else {
            $fichier = $this->upload->data();
            $nomfichier = $fichier['file_name'];
            $this->Recherche_model->set_recherche($nomfichier, $userdata['id']);
            redirect('/admin_recherches', 'refresh');
        }
    }

    public function delete() {
        $userdata = $this->session->all_userdata();
        $this->load->helper('form');
        $this->load->helper('recherche_helper');
        $this->load->library('form_validation');
        $this->load->library('email');
        $this->load->library('upload');
        if (!isset($userdata['logged_in']) || $userdata['logged_in'] == FALSE || $userdata['role'] != 'admin') {

            redirect('/home/login', 'refresh');
        }

        $this->form_validation->set_rules('recherche-delete', 'Recherche de compétence', 'required|min_length[1]');
        if ($this->form_validation->run() == FALSE) {
            $info = $this->Recherche_model->get_recherche_all();
            $data['nbr_recherches'] = count($info);
            $data['info'] = $info;
            $data['title'] = 'Administration';
            $data['menu'] = 'admin_recherches';

            $this->load->view('include/admin_header', $data);
            $this->load->view('admin_recherches', $data);
            $this->load->view('include/footer');
        } else {
            $this->Recherche_model->delete_recherche($this->input->post('recherche-delete'));
            redirect('/admin_recherches', 'refresh');
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
