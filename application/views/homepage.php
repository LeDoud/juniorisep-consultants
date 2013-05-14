
<div class="row-fluid">
    <div class="span20 offset1">
        <?php
        $userdata = $this->session->all_userdata();
        if (isset($userdata['annonce']) && $userdata['annonce'] == TRUE) {
            echo '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button><p>Merci d\'avoir rempli ce formulaire, vous pouvez renseigner vos différentes compétences dès à présent dans l\'onglet <i class="icon-user icon-white"></i>.</p><p>Vous pouvez aussi regardez les différentes propositions de missions du moment dans <i class="icon-shopping-cart icon-white"></i>.</p><p>Si vous êtes consultant inscrit, vous pourrez bientôt avoir accès à la totalité de l\'espace consulant.</p><p>C’est à dire : <li>Postuler aux missions <i class="icon-shopping-cart icon-white"></i></li><li>S’inscrire aux formations <i class="icon-briefcase icon-white"></i></li><li>Découvrir des offres de stage <i class="icon-gift icon-white"></i></li></p></div>';
            $this->session->set_userdata('annonce', FALSE);
        }
        ?>
    </div> </div>
<div class="row-fluid">
    <div class="span20 offset1 well">
        <h2>Espace Consultant</h2>
    </div>

</div>
<div class="row-fluid">
    <div id="carre1" class="span6 offset1 well"><h3><a href="<?= site_url() ?>user"><img src="<?php echo base_url('assets/img/Shirt.png') ?>">Profil</a></h3></div>
    <div id="carre2" class="span6 offset1 well"><h3><a href="<?= site_url() ?>recherche"><img src="<?php echo base_url('assets/img/Wallet.png') ?>">Missions</a></h3></div>
    <?php
        if ($role != 'isepien') {
            echo'<div id="carre3" class="span6 offset1 well"><h3><a href="' . site_url() . 'formation"><img src="' . base_url('assets/img/Clipboard.png') . '">Formations</a></h3></div>';
        } else {
            echo'<div id="carre3" class="span6 offset1 well" ><h3 data-toggle="tooltip" onmouseout="$(this).tooltip(\'hide\');" onmouseover="$(this).tooltip(\'show\');" title="Inscris toi à la Junior pour pouvoir accéder aux formations !"><img src="' . base_url('assets/img/Clipboard.png') . '">Formations</h3></div>';
        }
    ?>
    </div>
    <div class="row-fluid">
        <div class="span14 offset1 well" id="twitter"></div>
    <?php
        if ($role != 'isepien') {
            echo'<div id="carre4" class="span6 well"><h3><a href="' . site_url() . 'stage"><img src="' . base_url('assets/img/Briefcase.png') . '">Stages</a></h3></div>';
        } else {
            echo'<div id="carre4" class="span6 well" ><h3 data-toggle="tooltip" onmouseout="$(this).tooltip(\'hide\');" onmouseover="$(this).tooltip(\'show\');" title="Inscris toi à la Junior pour pouvoir accéder aux offres de stage !"><img src="' . base_url('assets/img/Briefcase.png') . '">Stages</h3></div>';
        }
    ?>
</div>
<script src="https://widgets.twimg.com/j/2/widget.js"></script>
<script>
    document.write = function() {
        var str = '';
        for (var i = 0; i < arguments.length; i++) {
            str += arguments[i];
        }
        document.getElementById('twitter').innerHTML += str;
    };

    new TWTR.Widget({
        version: 2,
        type: 'profile',
        rpp: 15,
        interval: 6000,
        width: 'auto',
        height: 150,
        theme: {
            shell: {
                background: '#f5f5f5',
                color: '#70549a'
            },
            tweets: {
                background: '#f6f6f6',
                color: '#70549a',
                links: '#1388d2'
            }
        },
        features: {
            scrollbar: true,
            loop: false,
            live: true,
            hashtags: true,
            timestamp: true,
            avatars: true,
            behavior: 'all'
        }
    }).render().setUser('Developpez').start();
</script>