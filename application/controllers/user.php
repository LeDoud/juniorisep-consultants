<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends CI_Controller {

    public function index() {

        $userdata = $this->session->all_userdata();
        if (isset($userdata['logged_in']) && $userdata['logged_in'] == TRUE) {
            redirect('/user/view', 'refresh');
        } else {
            redirect('/home/login', 'refresh');
        }
    }

    public function firstime() {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('email');

        $userdata = $this->session->all_userdata();
        if (!isset($userdata['logged_in']) || $userdata['logged_in'] == FALSE || $userdata['first'] == FALSE) {
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

        $this->form_validation->set_rules('prenom', 'Prénom', 'trim|required|min_length[2]|max_length[15]|htmlspecialchars');
        $this->form_validation->set_rules('nom', 'Nom', 'trim|required|min_length[2]|max_length[15]|htmlspecialchars');
        $this->form_validation->set_rules('naissance', 'Date de naissance', 'trim|required|htmlspecialchars');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[50]|htmlspecialchars');
        $this->form_validation->set_rules('tel', 'Numéro de téléphone', 'trim|required|min_length[10]|max_length[15]|htmlspecialchars|numeric');
        $this->form_validation->set_error_delimiters('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>', '</div>');

        if ($this->form_validation->run() == FALSE) {
            $info = $this->User_model->get_user($userdata['login']);
            $data['title'] = '- Espace consultant -';
            $data['menu'] = 'profil';
            $data['info'] = $info;
            $this->load->view('include/header', $data);
            $this->load->view('firstConnect', $data);
            $this->load->view('include/footer');
        } else {

            $this->User_model->update_user($userdata['login']); //mis a jour du profil
            $this->session->set_userdata('first', FALSE); //desactivation de la 1ere connexion
            $this->session->set_userdata('annonce', TRUE); //message info

            $info = $this->User_model->get_user($userdata['login']);
            $this->session->set_userdata('prenom', $info['prenom']);
            $this->session->set_userdata('nom', $info['nom']);
            $this->session->set_userdata('id', $info['id_consultant']);
            $this->session->set_userdata('role', 'isepien');

            $this->email->from('espace-consultant@juniorisep.com', 'Espace Consultant');
            $this->email->to('evan-yen@juniorisep.com'); //RH ou A1 ...
            $this->email->set_mailtype("html");
            $this->email->subject('[Espace Consultant] Nouvel utilisateur');
            $this->email->message('<strong>' . $this->input->post('prenom') . ' ' . $this->input->post('nom') . '</strong> vient de s’inscrire.<br/> S’il est consultant inscrit à la Junior, veuillez activer ses droits via l’interface d’administration de l’espace consultant prévue à cet effet.<br/><br/>Bonne journée ;)');

            $this->email->send();

            redirect('/home/accueil', 'refresh');
        }
    }

    public function update() {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->helper('competences_helper');

        $userdata = $this->session->all_userdata();
        if (!isset($userdata['logged_in']) || $userdata['logged_in'] == FALSE || $userdata['first'] == TRUE) {
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

        $this->form_validation->set_rules('prenom', 'Prénom', 'trim|required|min_length[2]|max_length[15]|htmlspecialchars');
        $this->form_validation->set_rules('nom', 'Nom', 'trim|required|min_length[2]|max_length[15]|htmlspecialchars');
        $this->form_validation->set_rules('naissance', 'Date de naissance', 'trim|required|htmlspecialchars|min_length[10]|max_length[10]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[50]|htmlspecialchars');
        $this->form_validation->set_rules('tel', 'Numéro de téléphone', 'trim|required|min_length[10]|max_length[15]|htmlspecialchars|numeric');
        $this->form_validation->set_error_delimiters('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>', '</div>');

        if ($this->form_validation->run() == FALSE) {
            $info = $this->User_model->get_user($userdata['login']);
            $data['title'] = '- Espace consultant -';
            $data['menu'] = 'profil';
            $data['info'] = $info;
            $data['modal'] = TRUE;
            $competences = $this->Competence_model->get_consultant_competence($userdata['id']);
            $data['nbr_competence'] = count($competences);
            $lvl_c = array();
            $lvl_p = array();
            $lvl_n = array();
            $comp_n = array();
            $comp_index = array();
            for ($i = 0; $i < $data['nbr_competence']; $i++) {
                $lvl_c[$i] = traductionNiveauCouleur($competences[$i]['niveau']);
                $lvl_p[$i] = traductionNiveauP($competences[$i]['niveau']);
                $lvl_n[$i] = traductionNiveau($competences[$i]['niveau']);
                $comp_index[$i] = $competences[$i]['id_competences_eleves'];
                $co = $this->Competence_model->get_competence($competences[$i]['id_competence']);
                $comp_n[$i] = $co['nom_competence'];
            }
            $data['lvl_c'] = $lvl_c;
            $data['lvl_p'] = $lvl_p;
            $data['lvl_n'] = $lvl_n;
            $data['comp_n'] = $comp_n;
            $data['comp_index'] = $comp_index;
            $data['taille'] = count($c = $this->Competence_model->get_competence());
            $data['c'] = $c;
            $this->load->view('include/header', $data);
            $this->load->view('profil', $data);
            $this->load->view('include/footer');
        } else {
            $data['modal'] = FALSE;
            $this->User_model->update_user($userdata['login']); //mis a jour du profil
            $info = $this->User_model->get_user($userdata['login']);
            $this->session->set_userdata('prenom', $info['prenom']);
            $this->session->set_userdata('nom', $info['nom']);
            $this->session->set_userdata('id', $info['id_consultant']);
            $this->session->set_userdata('email', $info['email']);
            $this->session->set_userdata('role', $info['role']);
            redirect('/user', 'refresh');
        }
    }

    public function view() {
        $userdata = $this->session->all_userdata();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->helper('competences_helper');

        if (!isset($userdata['logged_in']) || $userdata['logged_in'] == FALSE) {
            redirect('/home/login', 'refresh');
        }
        if ($userdata['first'] == TRUE) {
            redirect('/user/firstime', 'refresh');
        }

        $info = $this->User_model->get_user($userdata['login']);
        $data['title'] = '- Espace consultant -';
        $data['menu'] = 'profil';
        $data['info'] = $info;

        $competences = $this->Competence_model->get_consultant_competence($userdata['id']);
        $data['nbr_competence'] = count($competences);
        $lvl_c = array();
        $lvl_p = array();
        $lvl_n = array();
        $comp_n = array();
        $comp_index = array();
        for ($i = 0; $i < $data['nbr_competence']; $i++) {
            $lvl_c[$i] = traductionNiveauCouleur($competences[$i]['niveau']);
            $lvl_p[$i] = traductionNiveauP($competences[$i]['niveau']);
            $lvl_n[$i] = traductionNiveau($competences[$i]['niveau']);
            $comp_index[$i] = $competences[$i]['id_competences_eleves'];
            $co = $this->Competence_model->get_competence($competences[$i]['id_competence']);
            $comp_n[$i] = $co['nom_competence'];
        }
        $data['lvl_c'] = $lvl_c;
        $data['lvl_p'] = $lvl_p;
        $data['lvl_n'] = $lvl_n;
        $data['comp_n'] = $comp_n;
        $data['comp_index'] = $comp_index;
        $data['taille'] = count($c = $this->Competence_model->get_competence());
        $data['c'] = $c;

        $this->load->view('include/header', $data);
        $this->load->view('profil', $data);
        $this->load->view('include/footer');
    }

    public function recherche_competences() {
        redirect('/recherche', 'refresh');
    }

    public function formations() {
        redirect('/formation', 'refresh');
    }

    public function accueil() {
        redirect('/home', 'refresh');
    }

    public function competences() {
        redirect('/competence', 'refresh');
    }

    public function profil() {
        redirect('/user', 'refresh');
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
