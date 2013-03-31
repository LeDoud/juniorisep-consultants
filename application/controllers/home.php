<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller {

    /**
     * Controller page d'accueil et login
     */
    public function index() {

        $userdata = $this->session->all_userdata();
        if (isset($userdata['logged_in']) && $userdata['logged_in'] == TRUE) {
            redirect('/home/accueil', 'refresh');
        } else {
            redirect('/home/login', 'refresh');
        }
    }

    public function login() {
        $this->load->helper('form');

        $userdata = $this->session->all_userdata();
        if (isset($userdata['logged_in']) && $userdata['logged_in'] == TRUE) {
            redirect('/home/accueil', 'refresh');
        }

        $username = $this->input->post('login');
        $password = $this->input->post('pwd');
        if (!empty($username) && !empty($password)) {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_POST => 1,
                CURLOPT_HEADER => 1,
                CURLOPT_URL => 'https://webextv.isep.fr/gcma/vlogin.php',
                CURLOPT_FRESH_CONNECT => 1,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_FORBID_REUSE => 1,
                CURLOPT_TIMEOUT => 4,
                CURLOPT_POSTFIELDS => http_build_query(array(
                    'loginu' => $username,
                    'passwd' => $password,
                    'cmd' => 'Entrer !'
                )),
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_SSL_VERIFYHOST => 0
            ));
            $result = curl_exec($curl);
            curl_close($curl);
        } else {
            $result = 'vide';
        }
        $data['title'] = 'Espace consultant';
        //if (!preg_match("/Erreur de Login ou mot de passe !!/", $result)) {
        if (strpos($result, 'Location: debut.php') !== false) {
            $userdata = array(
                'login' => $username,
                'logged_in' => TRUE
            );
            $this->session->set_userdata($userdata);

            if (count($info = $this->User_model->get_user($username)) == 0) {
                //1ere connexion, on crée le compte dans la db
                $this->User_model->insert_user($username);
                //on redirige vers le profil pour compléter les informations
                $this->session->set_userdata('first', TRUE);
                $this->session->set_userdata('role', 'isepien');

                redirect('/user/firstime', 'refresh');
            } else {
                //sinon le compte existe déjà !
                if (empty($info['nom']) || empty($info['prenom'])) {
                    $this->session->set_userdata('first', TRUE);
                    redirect('/user/firstime', 'refresh');
                } else {
                    $this->session->set_userdata('first', FALSE);
                    $this->session->set_userdata('prenom', $info['prenom']);
                    $this->session->set_userdata('nom', $info['nom']);
                    $this->session->set_userdata('role', $info['role']);
                    $this->session->set_userdata('id', $info['id_consultant']);
                    $this->session->set_userdata('email', $info['email']);
                    $this->session->set_userdata('tel', $info['tel']);

                    $this->User_model->update_user_lastConnect($username);
                    redirect('/home/accueil', 'refresh');
                }
            }
        } else {
            if ($result != 'vide') {
                $data['message'] = 'Erreur de login ou de mot de passe !';
            } else {
                $data['message'] = '';
            }
            $this->load->view('include/header', $data);
            $this->load->view('login', $data);
            $this->load->view('include/footer', $data);
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('/home/login', 'refresh');
    }

    public function accueil() {
        $userdata = $this->session->all_userdata();
        $this->load->helper('accueils_helper');
        if (!isset($userdata['logged_in']) || $userdata['logged_in'] == FALSE) {

            redirect('/home/login', 'refresh');
        }
        if ($userdata['first'] == TRUE) {
            redirect('/user/firstime', 'refresh');
        }
        $data['title'] = '- Espace consultant - ';
        $data['message'] = ' Bienvenue ! ';
        $data['menu'] = 'home';
        $data['role'] = $userdata['role'];

        $this->load->view('include/header', $data);
        $this->load->view('homepage', $data);
        $this->load->view('include/footer');
    }

    public function profil() {
        redirect('/user', 'refresh');
    }

    public function recherche_competences() {
        redirect('/recherche', 'refresh');
    }

    public function formations() {
        redirect('/formation', 'refresh');
    }

    public function admin() {
        redirect('/admin', 'refresh');
    }

}

?>