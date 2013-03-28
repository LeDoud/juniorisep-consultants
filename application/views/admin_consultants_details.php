<!-- En-tete -->
<div class="row-fluid">
    <div class="span18 offset2 well">
        <h2><img src="<?php echo base_url('assets/img/Shirt.png') ?>">
            <?php echo $info['prenom'] . ' ' . $info['nom']; ?></h2>
    </div>
</div>
<!-- Corps -->
<div class="row-fluid">
    <div class="span8 offset2 well ">

        <h3><img src="<?php echo base_url('assets/img/Name_Card.png') ?>">
            Informations</h3>
    </div>
    <div class="span8 offset2 well">
        <h3><img src="<?php echo base_url('assets/img/Whiteboard.png') ?>">
            Compétences</h3>
    </div>
</div>
<div class="row-fluid">
    <!-- 1ere colonne -->
    <div class="span8 offset2">
        <table class="table table-striped table-bordered table-hover">

            <tr><td>Login </td><td><strong><?php echo $info['login']; ?></strong></td>
            <tr><td>Email </td><td><strong><?php echo $info['email']; ?></strong></td>
            <tr><td>Prénom </td><td><strong><?php echo $info['prenom']; ?></strong></td>
            <tr><td>Nom </td><td><strong><?php echo $info['nom']; ?></strong></td>
            <tr><td>Promotion </td><td><strong><?php echo $info['promotion']; ?></strong></td>
            <tr><td>Date de naissance </td><td><strong><?php echo $info['naissance']; ?></strong></td>
            <tr><td>Téléphone </td><td><strong><?php echo $info['tel']; ?></strong></td>
        </table>
        <br/>
        <br/>
    </div>
    <!-- 2eme colonne -->
    <div class="span8 offset2">
        <table class="table table-striped table-bordered table-hover">
            <?php for ($i = 0; $i < $nbr_competence; $i++) {
            ?>
                <tr><td width="40%"><?php echo $comp_n[$i]; ?></td><td width="60%"><div class="progress">
                            <div onmouseout="$(this).tooltip('hide');" onmouseover="$(this).tooltip('show');" data-toggle="tooltip" data-original-title="<?php echo $lvl_n[$i]; ?>" class="bar" style="width: <?php echo $lvl_p[$i]; ?>%;background-image: none;background-color: <?php echo $lvl_c[$i]; ?>;"></div>
                        </div></td></tr>
            <?php
            }
            if ($nbr_competence == 0) {
                echo'<tr><td colspan="2">Aucune compétence pour le moment</td></tr>';
            }
            ?></table>

        <br/>
        <br/>
    </div>

</div>