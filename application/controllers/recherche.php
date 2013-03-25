<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Recherche extends CI_Controller {

    public function index() {

        $userdata = $this->session->all_userdata();
        if (isset($userdata['logged_in']) && $userdata['logged_in'] == TRUE) {
            redirect('/recherche/view', 'refresh');
        } else {
            redirect('/home/login', 'refresh');
        }
    }

    public function view() {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->helper('recherche_helper');
        $userdata = $this->session->all_userdata();
        if (!isset($userdata['logged_in']) || $userdata['logged_in'] == FALSE) {
            redirect('/home/login', 'refresh');
        }
        if ($userdata['first'] == TRUE) {
            redirect('/user/firstime', 'refresh');
        }
        $data['title'] = '- Espace consultant -';
        $data['menu'] = 'recherche';
        $data['role'] = $userdata['role'];
        $data['userdata_id'] = $userdata['id'];

        $info = $this->Recherche_model->get_recherche();
        $data['nbr_recherches'] = count($info);
        $data['info'] = $info;


        $this->load->view('include/header', $data);
        $this->load->view('recherche_competences', $data);
        $this->load->view('include/footer');
    }

    public function postulate() {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('email');
        $this->load->helper('recherche_helper');
        $userdata = $this->session->all_userdata();
        if (!isset($userdata['logged_in']) || $userdata['logged_in'] == FALSE || $userdata['role'] == 'isepien') {
            redirect('/home/login', 'refresh');
        }
        $this->form_validation->set_message('required', 'Le champ %s est requis !');
        $this->form_validation->set_message('trim', 'Les caractères spéciaux ne sont pas accepté pour le  champ %s !');
        $this->form_validation->set_message('htmlspecialchars', 'Les caractères spéciaux ne sont pas accepté pour le  champ %s !');
        $this->form_validation->set_message('max_length', 'Le champ %s doit être plus court !');
        $this->form_validation->set_message('min_length', 'Le champ %s doit être plus long !');

        $this->form_validation->set_rules('recherche-post', 'Recherche', 'trim|required|min_length[1]');
        $this->form_validation->set_rules('motivation', 'Motivation', 'trim|required|min_length[50]|max_length[1000]');
        $this->form_validation->set_error_delimiters('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>', '</div>');

        if ($this->form_validation->run() == FALSE || (checkConsultant($this->input->post('recherche-post'), $userdata['id']) == TRUE)) {
            $data['title'] = '- Espace consultant -';
            $data['menu'] = 'recherche';
            $data['role'] = $userdata['role'];
            $data['userdata_id'] = $userdata['id'];

            $info = $this->Recherche_model->get_recherche();
            $data['nbr_recherches'] = count($info);
            $data['info'] = $info;
            $data['modal'] = TRUE;
            $data['id_mission'] = $this->input->post('recherche-post');

            $this->load->view('include/header', $data);
            $this->load->view('recherche_competences', $data);
            $this->load->view('include/footer');
        } else {
            $data['modal'] = FALSE;
            $data['id_mission'] = "";
            
            if (count($this->Recherche_model->check_consultant(decrypt($this->input->post('recherche-post')), $userdata['id'])) == 0) {

            $this->Recherche_model->postulate_recherche(decrypt($this->input->post('recherche-post')), $userdata['id']);
            $recherche = $this->Recherche_model->get_recherche(decrypt($this->input->post('recherche-post')));
            $user_cdp = $this->User_model->get_user_byId($recherche['id_cdp']);
            $this->email->from('espace-consultant@juniorisep.com', $userdata['prenom'] . ' ' . $userdata['nom']);
            $this->email->to($user_cdp['email']);
            $this->email->set_mailtype("html");
            $this->email->subject('[Espace Consultant] Postulant pour une mission [' . $recherche['nom_mission'] . ']');
            $this->email->message('<strong>' . $userdata['prenom'] . ' ' . $userdata['nom'] . '</strong> vient de postuler à ta mission : <strong>' . $recherche['nom_mission'] . '</strong><br/><br/>Voici son message : <br/><br/><em>&laquo;' . $this->input->post('motivation') . '&raquo;</em><br/><br/><a href="mailto:' . $userdata['email'] . '">Lui répondre par mail</a> ou par téléphone : '.$userdata['tel'] .'<br/><br/><br/>Bonne journée ;)');

            $this->email->send();

            }
            redirect('/recherche', 'refresh');
        }
    }

    public function formations() {
        redirect('/formation', 'refresh');
    }

    public function profil() {
        redirect('/user', 'refresh');
    }

    public function accueil() {
        redirect('/home', 'refresh');
    }

    public function recherche_competences() {
        redirect('/recherche', 'refresh');
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
