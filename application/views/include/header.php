<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="utf-8">
        <title><?php echo $title; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="onglet consultant junior isep">
        <meta name="author" content="Edouard VAN YEN">

        <link href="<?php echo base_url('assets/css/espace-bootstrap.min.css') ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/css/espace-bootstrap-responsive.min.css') ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/css/font-awesome.css') ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/css/datepicker.css') ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/css/custom.css') ?>" rel="stylesheet">
        <?php if ($title == 'Espace consultant') { //page login
        ?>
            <link href="<?php echo base_url('assets/css/login.css') ?>" rel="stylesheet">
        <?php } ?>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap-datepicker.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/custom.js') ?>"></script>

        <link rel="shortcut icon" href="<?php echo base_url('assets/ico/favicon.ico') ?>">

    </head>
    <body>
        <?php
        $userdata = $this->session->all_userdata();
        if (isset($userdata['logged_in']) && $userdata['logged_in'] == TRUE) {
        ?>
        <header id="banner" class="navbar" role="banner">
            <div class="banner-inner">
                <a href="<?= site_url() ?>"><img src="<?php echo base_url('assets/img/logo.png') ?>" alt="Logo de Junior ISEP" /></a>
                <h1>Innover pour vos projets</h1>
            </div>
            <div class="navbar-inner">
                <div class="container">
                    <a class="brand hidden-desktop">Menu</a>
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <nav id="nav-main" class="nav-collapse" role="navigation">
                        <ul id="menu-primary-navigation" class="nav">
                            <li><a><i><?= (isset($userdata['prenom'])) ? $userdata['prenom'] . ' ' . $userdata['nom'] : $userdata['login'] ?></i></a></li>
                            <li <?php echo ($menu == 'home') ? 'class="active menu-"' : ''; ?>><a href="<?= site_url() ?>"><i class="icon-home"></i></a></li>
                            <li <?php echo ($menu == 'profil') ? 'class="active menu-"' : ''; ?>><a href="<?= site_url() ?>user"><i class="icon-user icon-white"></i>Profil</a></li>
                            <li <?php echo ($menu == 'recherche') ? 'class="active menu-"' : ''; ?>><a href="<?= site_url() ?>recherche"><i class="icon-shopping-cart"></i>Missions</a></li>
                        <?php if ($userdata['role'] != 'isepien') {
                        ?><li <?php echo ($menu == 'formation') ? 'class="active menu-"' : ''; ?>><a href="<?= site_url() ?>formation"><i class="icon-briefcase"></i>Formations</a></li><?php } else {
 ?>
                            <li><a data-placement="bottom" data-toggle="tooltip" onmouseout="$(this).tooltip('hide');" onmouseover="$(this).tooltip('show');" title="Inscris toi à la Junior pour pouvoir accéder aux formations !"><i class="icon-briefcase"></i>Formations</a></li>
<?php } ?>

                        <?php if ($userdata['role'] == 'admin') { ?><li><a href="<?= site_url() ?>admin"><i class="icon-lock"></i>Administration</a></li> <?php } ?>
                        <li><a href="logout"><i class="icon-off"></i>Déconnexion</a></li>

                    </ul>            </nav>
            </div>
        </div>
    </header>
    <?php } ?>