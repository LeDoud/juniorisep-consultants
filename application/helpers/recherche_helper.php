<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function notation($chiffre) {
    $rate = '<a data-placement="top" data-toggle="tooltip" onmouseout="$(this).tooltip(\'hide\');" onmouseover="$(this).tooltip(\'show\');" data-original-title="' . $chiffre . '/5" href="">';
    for ($i = 0; $i < $chiffre; $i++) {
        $rate .= '<i class="icon icon-star" style="color:darkviolet"></i>';
    }
    $rate.='</a>';
    return $rate;
}

function respo($id_cdp) {
    $CI = & get_instance();
    $CI->load->model('user_model');
    $info = $CI->User_model->get_user_byId($id_cdp);
    return $info['prenom'] . ' ' . $info['nom'];
}

function documents($string) {
    if ($string == '0' || $string == '') {
        return 'Aucun';
    } else {
        return '<a data-placement="top" onmouseout="$(this).tooltip(\'hide\');" onmouseover="$(this).tooltip(\'show\');" target="_blank" href="' . site_url() . 'tmp/' . $string . '" title="Documentation"><i class="icon icon-book"></i></a>';
    }
}

function formatDate($date) {
    //setlocale(LC_ALL, 'fr_FR');
    //return strftime("Le %d %B %Y", strtotime($date));
    $_MOIS = array(1 => "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
    $_JOURS = array(1 => "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche");
    $date = strtotime($date);
    return '' . $_JOURS[date("N", $date)] . ' ' . date("d", $date) . ' ' . $_MOIS[date("n", $date)] . ' ' . date("Y", $date);
    ;
}

function postuler($role, $information, $user_id) {
    if ($role == 'isepien') {
        $string = '<a data-placement="top" data-toggle="tooltip" onmouseout="$(this).tooltip(\'hide\');" onmouseover="$(this).tooltip(\'show\');" data-original-title="Pour postuler, inscris toi d’abord à la Junior ;)" href=""><i class="icon icon-flag"></i></a>';
    } else {
        $string = (checkConsultant($information, $user_id) == TRUE) ? 'Postulé!' : '<a data-placement="top" data-toggle="modal" onmouseout="$(this).tooltip(\'hide\');" onmouseover="$(this).tooltip(\'show\');document.getElementById(\'recherche-post\').value=\'' . encrypt($information) . '\'" data-original-title="Postuler" href="#post-recherche"><i class="icon icon-flag"></i></a>';
    }

    return $string;
}

function getListConsultants($id_recherche) {
    $CI = & get_instance();
    $CI->load->model('recherche_model');
    $CI->load->model('user_model');


    $info = $CI->Recherche_model->get_consultants_recherche($id_recherche);

    $nbr = count($info);
    $title = '';
    for ($i = 0; $i < $nbr; $i++) {
        $user = $CI->User_model->get_user_byId($info[$i]['id_consultant']);
        $title.=$user['prenom'] . ' ' . $user['nom'] . '<br/>';
    }
    if ($title == '') {
        $string = '<a data-placement="top" onmouseout="$(this).tooltip(\'hide\');" onmouseover="$(this).tooltip(\'show\');" href="" data-html="TRUE" title="Personne pour le moment !"><i class="icon icon-user"></i></a>';
    } else {
        $string = '<a data-placement="top" onmouseout="$(this).tooltip(\'hide\');" onmouseover="$(this).tooltip({title:\''.str_replace('"','’',str_replace("'","’",$title)).'\'});$(this).tooltip(\'show\');" href="" data-html="TRUE"><i class="icon icon-user"></i></a>';
    }
    return $string;
}

function checkConsultant($id_recherche, $id_user) {
    $CI = & get_instance();
    $CI->load->model('recherche_model');
    if (count($CI->Recherche_model->check_consultant($id_recherche, $id_user)) == 0) {
        return FALSE;
    }
    return TRUE;
}

function encrypt($string) {
    $key = '<jun!or!sep?2013/>';
    $result = '';

    $n = strlen($string);
    for ($i = 1; $i <= $n; $i++) {
        $char = substr($string, $i - 1, 1);
        $keychar = substr($key, ($i % strlen($key)) - 1, 1);
        $char = chr(ord($char) + ord($keychar));
        $result .= $char;
    }

    $result = base64_encode($result);
    $result = str_replace(array('+', '/', '='), array('-', '_', ''), $result);

    return $result;
}

function decrypt($string) {
    $key = '<jun!or!sep?2013/>';
    $string = str_replace(array('-', '_'), array('+', '/'), $string);
    if (strlen($string) % 4) {
        $string .= substr('====', $string);
    }
    $string = base64_decode($string);

    $result = '';

    $n = strlen($string);
    for ($i = 1; $i <= $n; $i++) {
        $char = substr($string, $i - 1, 1);
        $keychar = substr($key, ($i % strlen($key)) - 1, 1);
        $char = chr(ord($char) - ord($keychar));
        $result .= $char;
    }

    return $result;
}

function update_recherche($recherche) {

    return 'document.getElementById(\'id-recherche-update\').value=\'' . $recherche['id_recherche'] . '\';document.getElementById(\'nom_mission-update\').value=\'' . $recherche['nom_mission'] . '\';document.getElementById(\'priorite-update\').value=\'' . $recherche['priorite'] . '\';document.getElementById(\'type-update\').value=\'' . $recherche['type'] . '\';document.getElementById(\'competences-update\').value=\'' . $recherche['competences'] . '\';document.getElementById(\'difficulte-update\').value=\'' . $recherche['difficulte'] . '\';document.getElementById(\'nbr_intervenants-update\').value=\'' . $recherche['nbr_intervenants'] . '\';appendEditor(\'' . str_replace('"', "\'", str_replace("'", "\'", $recherche['details_recherche'])) . '\');';
}

?>
