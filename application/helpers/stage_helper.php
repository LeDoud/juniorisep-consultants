<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


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

function update_stage($stage) {

    return 'document.getElementById(\'id-stage-update\').value=\'' . $stage['id_stage'] . '\';document.getElementById(\'poste-update\').value=\'' . $stage['poste'] . '\';document.getElementById(\'societe-update\').value=\'' . $stage['societe'] . '\';document.getElementById(\'duree-update\').value=\'' . $stage['duree'] . '\';document.getElementById(\'competences-update\').value=\'' . $stage['competences'] . '\';appendEditor(\'' . str_replace('"', "\'", str_replace("'", "\'", $stage['details_stage'])) . '\');';
}

?>
