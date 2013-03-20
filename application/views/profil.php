<!-- En-tete -->
<div class="row-fluid">
    <div class="span18 offset2 well">
        <h2><img src="<?php echo base_url('assets/img/Shirt.png') ?>">
            Mon Profil</h2>
    </div>
</div>
<!-- Corps -->
<div class="row-fluid">
    <div class="span8 offset2 well ">

        <h3><img src="<?php echo base_url('assets/img/Name_Card.png') ?>">
            Mes informations</h3>
    </div>
    <div class="span8 offset2 well">
        <h3><img src="<?php echo base_url('assets/img/Whiteboard.png') ?>">
            Mes compétences</h3>
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
        <a href="#update-profil" role="button" class="btn btn-primary" data-toggle="modal">Mettre à jour mes informations</a>
        <br/>
        <br/>
    </div>
    <!-- 2eme colonne -->
    <div class="span8 offset2">
        <table class="table table-striped table-bordered table-hover">
            <?php for ($i = 0; $i < $nbr_competence; $i++) {
            ?>
                <tr><td width="30%"><?php echo $comp_n[$i]; ?></td><td width="60%"><div class="progress">
                            <div onmouseout="$(this).tooltip('hide');" onmouseover="$(this).tooltip('show');" data-toggle="tooltip" data-original-title="<?php echo $lvl_n[$i]; ?>" class="bar" style="width: <?php echo $lvl_p[$i]; ?>%;background-image: none;background-color: <?php echo $lvl_c[$i]; ?>;"></div>
                        </div></td><td width="10%" style="text-align:center "><a data-placement="right" onmouseout="$(this).tooltip('hide');" onmouseover="$(this).tooltip('show');document.getElementById('compet-delete').value='<?php echo encrypt($comp_index[$i]); ?>'" href="#delete-competence" data-toggle="modal" data-original-title="Supprimer" ><i class="icon-trash"></i></a></td></tr>
            <?php } ?></table>
        <a href="#add-competence" role="button" class="btn btn-primary" data-toggle="modal">Ajouter une compétence</a>
        <?php if ($nbr_competence != 0) {
        ?>
                <a href="#update-competence" role="button" class="btn btn-primary" data-toggle="modal">Mettre à jour mes compétences</a>
        <?php } ?>
            <br/>
            <br/>
        </div>

    </div>

    <!-- Modal Update Profil-->
    <div id="update-profil" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="update-title" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="update-title">Mettre à jour mes informations</h3>
        </div>
        <br/>
        <div class="modal-body">
        <?php echo validation_errors(); ?>
        <?php echo form_open('user/update', array('class' => 'form-horizontal')); ?>

            <div class="control-group">
                <label class="control-label" for="login">Login</label>
                <div class="controls">
                    <span id="login" name="login" class="uneditable-input"><?php echo $info['login']; ?></span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="email">Email</label>
                <div class="controls">
                    <input type="text" id="email" name="email" value="<?php echo $info['email']; ?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="prenom">Prénom</label>
                <div class="controls">
                    <input type="text" id="prenom" name="prenom" placeholder="Prénom" value="<?php echo $info['prenom']; ?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="nom">Nom</label>
                <div class="controls">
                    <input type="text" id="nom" name="nom" placeholder="Nom" value="<?php echo $info['nom']; ?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="promo">Promotion</label>
                <div class="controls">
                    <select class="span2" id="promo" name="promo" >
                    <?php
                    for ($i = 0; $i < 6; $i++) {
                        if ($info['promotion'] == (date('Y') + $i)) {
                            echo '<option selected value="' . (date('Y') + $i) . '">' . (date('Y') + $i) . '</option>';
                        } else {
                            echo '<option value="' . (date('Y') + $i) . '">' . (date('Y') + $i) . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="naissance">Date de naissance</label>
            <div class="controls">
                <div class="input-append date" id="dpYears" data-date="1992-01-01" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
                    <input class="span3" id="naissance" name="naissance" size="16" type="text" value="<?php echo $info['naissance']; ?>" readonly="">
                    <span class="add-on"><i class="icon-calendar"></i></span>
                </div>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="tel">Téléphone</label>
            <div class="controls">
                <input type="text" id="tel" name="tel" placeholder="Numéro de téléphone" value="<?php echo $info['tel']; ?>">
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <button type="submit" class="btn btn-primary">Mettre à jour</button>
            </div>
        </div>
        </form>
    </div>
</div>
<!-- Modal Update Competence -->
<div id="update-competence" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="add-title" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="update-title">Mise à jour des compétences</h3>
    </div>
    <br/>
    <div class="modal-body">
        <?php echo validation_errors(); ?>
        <?php echo form_open('competence/update', array('class' => 'form-horizontal')); ?>

                    <div class="control-group">
                        <label class="control-label" for="nom-compet-update">Compétence</label>
                        <div class="controls">
                            <select id="nom-compet-update" name="nom-compet-update" class="span3">
                    <?php
                    for ($i = 0; $i < $nbr_competence; $i++) {
                        echo'<option value="' . encrypt($comp_index[$i]) . '">' . $comp_n[$i] . '</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="lvl-compet-update">Niveau</label>
            <div class="controls">
                <select id="lvl-compet-update" name="lvl-compet-update" class="span3">
                    <?php
                    for ($i = 1; $i < 6; $i++) {

                        echo'<option value="' . $i . '">' . traductionNiveau($i) . '</option>';
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="control-group">
            <div class="controls">
                <button type="submit" class="btn btn-primary">Mettre à jour</button>
            </div>
        </div>
        </form>
    </div>
</div>

<!-- Modal Add Competence -->            
<div id="add-competence" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="add-title" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="add-title">Nouvelle compétence</h3>
    </div>
    <br/>
    <div class="modal-body">
        <?php echo validation_errors(); ?>
        <?php echo form_open('competence/add', array('class' => 'form-horizontal')); ?>

                    <div class="control-group">
                        <label class="control-label" for="nom-compet">Compétence</label>
                        <div class="controls">
                            <select id="nom-compet" name="nom-compet" class="span3">
                    <?php
                    for ($i = 0; $i < $taille; $i++) {
                        if (!empty($c[$i]['nom_competence']) && !compareCompetence($comp_n, $c[$i]['nom_competence'])) {
                            echo'<option value="' . encrypt($c[$i]['id_competence']) . '">' . $c[$i]['nom_competence'] . '</option>';
                        }
                    }
                    ?>

                </select>

            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="lvl-compet">Niveau</label>
            <div class="controls">
                <select id="lvl-compet" name="lvl-compet" class="span3">

                    <?php
                    for ($i = 1; $i < 6; $i++) {
                        echo'<option value="' . $i . '">' . traductionNiveau($i) . '</option>';
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="control-group">
            <div class="controls">
                <button type="submit" class="btn btn-primary">Ajouter</button>
            </div>
        </div>
        </form>
    </div>
</div>

<!-- Modal Delete Competence -->
<div id="delete-competence" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="delete-title" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="delete-title">Supprimer cette compétence ?</h3>
    </div>
    <br/>
    <div class="modal-body">
        Voulez-vous vraiment supprimer cette compétence ?

    </div>
    <?php echo form_open('competence/delete'); ?>
                    <div class="modal-footer">

                        <input type="hidden" name="compet-delete" id="compet-delete" value="">
                        <button class="btn btn-primary" type="submit">Oui</button>
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Non</button>
                    </div>
                </form>
                </div>

                <!-- JavaScript -->

<?php echo (isset($modal) && $modal == TRUE) ? "<script>$('#update-profil').modal('show');</script>" : "" ?>
<script>
    $('#dpYears').datepicker();
</script>