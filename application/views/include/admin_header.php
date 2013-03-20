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
        <link href="<?php echo base_url('assets/css/bootstrap-datetimepicker.min.css') ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/css/custom.css') ?>" rel="stylesheet">
        <?php if ($title == 'Espace consultant') { //page login
        ?>
            <link href="<?php echo base_url('assets/css/login.css') ?>" rel="stylesheet">
        <?php } ?>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap-datetimepicker.min.js') ?>"></script>
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
                            <li <?php echo ($menu == 'admin') ? 'class="active menu-"' : ''; ?>><a href="<?= site_url() . 'admin' ?>"><i class="icon-lock"></i></a></li>
                            <li <?php echo ($menu == 'admin_consultants') ? 'class="active menu-"' : ''; ?>><a href="<?= site_url() ?>admin_consultants"><i class="icon-user icon-white"></i>Consultants</a></li>
                            <li <?php echo ($menu == 'admin_recherches') ? 'class="active menu-"' : ''; ?>><a href="<?= site_url() ?>admin_recherches"><i class="icon-shopping-cart"></i>Recherches de compétences</a></li>
                            <li <?php echo ($menu == 'admin_formations') ? 'class="active menu-"' : ''; ?>><a href="<?= site_url() ?>admin_formations"><i class="icon-briefcase"></i>Formations</a></li>
                            <li><a href="<?= site_url() ?>"><i class="icon-home"></i>Accueil</a></li>
                            <li><a href="logout"><i class="icon-off"></i>Déconnexion</a></li>

                        </ul>            </nav>
                </div>
            </div>    
        </header>
    <?php } ?>