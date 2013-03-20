<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function documents($string=FALSE) {
    if ($string === FALSE) {
        return '<a data-placement="top" onmouseout="$(this).tooltip(\'hide\');" onmouseover="$(this).tooltip(\'show\');" href="" title="Inscris toi d’abord pour obtenir les documents !"><i class="icon icon-lock"></i></a>';
    } else {
        if ($string == '0' || $string == '') {
            return 'Aucun';
        } else {
            return '<a data-placement="top" onmouseout="$(this).tooltip(\'hide\');" onmouseover="$(this).tooltip(\'show\');" target="_blank" href="' . site_url() . 'tmp/' . $string . '" title="Documentation"><i class="icon icon-book"></i></a>';
        }
    }
}

function getListConsultants($id_formation) {
    $CI = & get_instance();
    $CI->load->model('formation_model');
    $CI->load->model('user_model');


    $info = $CI->Formation_model->get_consultants_formation($id_formation);

    $nbr = count($info);
    $title = '';
    for ($i = 0; $i < $nbr; $i++) {
        $user = $CI->User_model->get_user_byId($info[$i]['id_consultant']);
        $title.=$user['prenom'] . ' ' . $user['nom'] . '<br/>';
    }
    if ($title == '') {
        $string = '<a data-placement="top" onmouseout="$(this).tooltip(\'hide\');" onmouseover="$(this).tooltip(\'show\');" href="" data-html="TRUE" title="Personne pour le moment !"><i class="icon icon-user"></i></a>';
    } else {
        $string = '<a data-placement="top" onmouseout="$(this).tooltip(\'hide\');" onmouseover="$(this).tooltip(\'show\');" href="" data-html="TRUE" title="' . $title . '"><i class="icon icon-user"></i></a>';
    }
    return $string;
}

function checkConsultant($id_formation, $id_user) {
    $CI = & get_instance();
    $CI->load->model('formation_model');
    if (count($CI->Formation_model->check_consultant($id_formation, $id_user)) == 0) {
        return FALSE;
    }
    return TRUE;
}

function formatDate($date) {
    //setlocale(LC_ALL, 'fr_FR');
    //return strftime("Le %d %B %Y à %H:%M:%S", strtotime($date));
    $_MOIS = array(1 => "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
    $_JOURS = array(1 => "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche");
    $date = strtotime($date);
    return 'Le ' . $_JOURS[date("N", $date)] . ' ' . date("d", $date) . ' ' . $_MOIS[date("n", $date)] . ' ' . date("Y", $date) . ' à ' . strftime("%H:%M:%S", $date);
    ;
}

function encrypt($string) {
    $key = '<jun!or!sep?2013bis/>';
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
    $key = '<jun!or!sep?2013bis/>';
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

?>
