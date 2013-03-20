<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_consultants extends CI_Controller {

    public function index() {

        $userdata = $this->session->all_userdata();
        if (isset($userdata['logged_in']) && $userdata['logged_in'] == TRUE) {
            redirect('/admin_consultants/liste', 'refresh');
        } else {
            redirect('/home/login', 'refresh');
        }
    }

    public function liste() {
        $userdata = $this->session->all_userdata();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->helper('competences_helper');
        if (!isset($userdata['logged_in']) || $userdata['logged_in'] == FALSE || $userdata['role'] != 'admin') {

            redirect('/home/login', 'refresh');
        }

        $data['title'] = 'Administration';
        $data['menu'] = 'admin_consultants';

        $info = $this->User_model->get_user();
        $data['info'] = $info;
        $data['nbr_consultants'] = count($info);

        $this->load->view('include/admin_header', $data);
        $this->load->view('admin_consultants', $data);
        $this->load->view('include/footer');
    }

    public function change() {
        $this->load->library('email');
        $userdata = $this->session->all_userdata();
        if (!isset($userdata['logged_in']) || $userdata['logged_in'] == FALSE || $userdata['role'] != 'admin') {

            redirect('/home/login', 'refresh');
        }
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('role', 'Rôle', 'trim|required|htmlspecialchars');
        $this->form_validation->set_rules('thislogin', 'thislogin', 'trim|required');

        if ($this->form_validation->run() == FALSE) {

            $data['title'] = 'Administration';
            $data['menu'] = 'admin_consultants';

            $info = $this->User_model->get_user();
            $data['info'] = $info;
            $data['nbr_consultants'] = count($info);
            $this->load->view('include/admin_header', $data);
            $this->load->view('admin_consultants', $data);
            $this->load->view('include/footer');
        } else {
            $this->User_model->update_user_role($this->input->post('thislogin'));
            if ($this->input->post('role') == 'consultant') {
                $user = $this->User_model->get_user($this->input->post('thislogin'));
                $mail = $user['email'];

                $this->email->from('espace-consultant@juniorisep.com', 'Junior ISEP');
                $this->email->to($mail); //on previent qu'il est consultant
                $this->email->set_mailtype("html");
                $this->email->subject('[Junior ISEP - Espace Consultant] Activation du compte Consultant');
                $this->email->message('Nous avons le plaisir de t’annoncer l’activation de ton compte consultant.<br/> Tu peux dès à présent postuler aux missions et t’inscrire aux différentes formations proposées.<br/><br/>Bonne journée ;)<br/><br/>L’équipe de Junior ISEP');

                $this->email->send();
            } else if ($this->input->post('role') == 'admin') {
                $user = $this->User_model->get_user($this->input->post('thislogin'));
                $mail = $user['email'];

                $this->email->from('espace-consultant@juniorisep.com', 'Junior ISEP');
                $this->email->to($mail); //on previent qu'il est consultant
                $this->email->set_mailtype("html");
                $this->email->subject('[Junior ISEP - Espace Consultant] Activation du compte Admin');
                $this->email->message('Nous avons le plaisir de t’annoncer l’activation de ton compte administrateur.<br/> Tu peux dès à présent accéder à l’interface d’administration pour ajouter des recherches de compétences ou des formations.<br/><br/>Bonne journée ;)<br/><br/>L’équipe de Junior ISEP');

                $this->email->send();
            }
            redirect('/admin_consultants', 'refresh');
        }
    }

    public function details() {
        $userdata = $this->session->all_userdata();
        if (!isset($userdata['logged_in']) || $userdata['logged_in'] == FALSE || $userdata['role'] != 'admin') {

            redirect('/home/login', 'refresh');
        }
        $this->load->helper('competences_helper');
        if ($this->uri->segment(3) == 'logout') {
            redirect('/home/logout', 'refresh');
        } else if ($this->uri->segment(3) == '') {
            redirect('/admin_consultants', 'refresh');
        }
        $info = $this->User_model->get_user($this->uri->segment(3));
        if (count($info) == 0) {
            redirect('/admin_consultants', 'refresh');
        }

        $data['info'] = $info;
        $data['title'] = 'Administration';
        $data['menu'] = 'admin_consultants';

        $competences = $this->Competence_model->get_consultant_competence($info['id_consultant']);
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

        $this->load->view('include/admin_header', $data);
        $this->load->view('admin_consultants_details', $data);
        $this->load->view('include/footer');
    }

    public function admin() {
        redirect('/admin', 'refresh');
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
