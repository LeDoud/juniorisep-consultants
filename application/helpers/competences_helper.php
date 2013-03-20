<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function traductionNiveauCouleur($lvl) {
    if ($lvl == '1') {
        $color = "lightblue";
    } else if ($lvl == '2') {
        $color = "blue";
    } else if ($lvl == '3') {
        $color = "darkblue";
    } else if ($lvl == '4') {
        $color = "green";
    } else if ($lvl == '5') {
        $color = "darkgreen";
    }
    return $color;
}

function traductionNiveauP($lvl) {
    if ($lvl == '1') {
        $p = 20;
    } else if ($lvl == '2') {
        $p = 40;
    } else if ($lvl == '3') {
        $p = 60;
    } else if ($lvl == '4') {
        $p = 80;
    } else if ($lvl == '5') {
        $p = 100;
    }
    return $p;
}

function traductionNiveau($lvl) {
    if ($lvl == '1') {
        $niveau = 'Débutant';
    } else if ($lvl == '2') {
        $niveau = 'Faux-débutant';
    } else if ($lvl == '3') {
        $niveau = 'Normal';
    } else if ($lvl == '4') {
        $niveau = 'Bon';
    } else if ($lvl == '5') {
        $niveau = 'Très bon';
    }
    return $niveau;
}

function compareCompetence($tableau, $occurence) {
    $result = FALSE;
    $n = count($tableau);
    for ($j = 0; $j < $n; $j++) {
        if ($tableau[$j] == $occurence) {
            $result = TRUE;
            BREAK;
        }
    }

    return $result;
}

function checkConsultant($id_competence, $id_user) {
    $CI = & get_instance();
    $CI->load->model('competence_model');
    if (count($CI->Competence_model->check_consultant($id_competence, $id_user)) == 0) {
        return FALSE;
    }
    return TRUE;
}

function encrypt($string) {
    $key = '<jun!or!sep?2013!/>';
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
    $key = '<jun!or!sep?2013!/>';
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
