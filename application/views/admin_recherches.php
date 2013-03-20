<!-- En-tete -->
<div class="row-fluid">
    <div class="span20 offset2 well ">

        <h3><img src="<?php echo base_url('assets/img/Wallet.png') ?>">
            Administration - Recherche de compétences</h3>
    </div>

</div>
<!-- Corps -->
<div class="row-fluid">
    <!-- 1ere colonne -->
    <div class="span20 offset2">
        <table class="table table-striped table-bordered table-hover ">
            <thead><tr><th>Priorité</th><th>Type</th><th>Compétence(s) requise(s)</th><th>Difficulté</th><th>Consultant(s) requis</th><th>Chef de Projet</th><th>Posté le</th><th>Postulants</th><th>Document(s)</th><th>Visible ?</th><th>Supprimer</th><th>Détails</th></tr></thead>
            <tbody>
                <?php
                for ($i = 0; $i < $nbr_recherches; $i++) {
                    if ($info[$i]['dispo'] == 'oui') {
                        $select = form_open('admin_recherches/change', array('class' => 'form-horizontal')) . '<select id="dispo" name="dispo" class="input-small" onchange="this.form.submit();"><option value="oui" selected>oui</option><option value="non">non</option></select><input type="hidden" name="thisrecherche" id="thisrecherche" value="' . $info[$i]['id_recherche'] . '"></form>';
                    } else {
                        $select = form_open('admin_recherches/change', array('class' => 'form-horizontal')) . '<select id="dispo" name="dispo" class="input-small" onchange="this.form.submit();"><option value="oui" >oui</option><option value="non" selected>non</option>></select><input type="hidden" name="thisrecherche" id="thisrecherche" value="' . $info[$i]['id_recherche'] . '"></form>';
                    }
                    echo'<tr><td>' . $info[$i]['priorite'] . '</td><td>' . $info[$i]['type'] . '</td><td>' . $info[$i]['competences'] . '</td><td>' . notation($info[$i]['difficulte']) . '</td><td style="text-align:center;">' . ($info[$i]['nbr_intervenants']) . '</td><td style="text-align:center;">' . respo($info[$i]['id_cdp']) . '</td><td style="text-align:center;">' . formatDate($info[$i]['date']) . '</td><td style="text-align:center;">' . getListConsultants($info[$i]['id_recherche']) . '</td><td style="text-align:center;">' . documents($info[$i]['fichiers']) . '</td><td>' . $select . '</td><td style="text-align:center;"><a data-placement="top" onmouseout="$(this).tooltip(\'hide\');" onmouseover="$(this).tooltip(\'show\');document.getElementById(\'recherche-delete\').value=' . $info[$i]['id_recherche'] . '" href="#delete-recherche" data-toggle="modal" data-original-title="Supprimer"><i class="icon icon-trash"></i></a></td><td style="text-align:center;"><a onmouseout="$(this).popover(\'hide\');" onmouseover="$(this).popover(\'show\');" href="" data-toggle="popover" data-placement="bottom" data-content="' . $info[$i]['details_recherche'] . '" data-html="TRUE" data-original-title="Détails de la mission <strong>' . $info[$i]['nom_mission'] . '</strong>"><i class="icon icon-search"></i></a></td></tr>';
                }
                ?>
            </tbody>
        </table>
        <a href="#add-recherche" role="button" class="btn btn-primary" data-toggle="modal">Ajouter une recherche de compétences</a>
        <br/>
        <br/>
    </div>
</div>

<!-- Modal Add Recherche de Comp -->
<div id="add-recherche" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="recherche-title" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="recherche-title">Nouvelle recherche de compétences</h3>
    </div>
    <br/>
    <div class="modal-body">
        <?php echo validation_errors(); ?>
        <?php echo isset($error) ? $error : ''; ?>
        <?php echo form_open_multipart('admin_recherches/add', array('class' => 'form-horizontal')); ?>

                <div class="control-group">
                    <label class="control-label" for="nom_mission">Nom de la mission</label>
                    <div class="controls">
                        <input name="nom_mission" id="nom_mission" placeholder="Nom de l'étude" value="<?php echo set_value('nom_mission'); ?>">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="type">Type de mission</label>
                    <div class="controls">
                        <input name="type" id="type" placeholder="ex: Site vitrine, Application Mobile" value="<?php echo set_value('type'); ?>">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="competences">Compétences requises</label>
                    <div class="controls">
                        <input name="competences" id="competences" placeholder="ex: HTML/CSS & PHP/MySQL" value="<?php echo set_value('competences'); ?>">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="priorite">Priorité</label>
                    <div class="controls">
                        <select id="priorite" name="priorite" ><option value="Faible" <?php echo set_select('priorite', 'Faible'); ?>>Faible</option><option value="Moyenne" <?php echo set_select('priorite', 'Moyenne'); ?>>Moyenne</option><option value="Urgente" <?php echo set_select('priorite', 'Urgente'); ?>>Urgente</option></select>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="difficulte">Difficulté</label>
                    <div class="controls">
                        <select id="difficulte" name="difficulte"><option value="1" <?php echo set_select('difficulte', '1'); ?>>1</option><option value="2" <?php echo set_select('difficulte', '2'); ?>>2</option><option value="3" <?php echo set_select('difficulte', '3'); ?>>3</option><option value="4" <?php echo set_select('difficulte', '4'); ?>>4</option><option value="5" <?php echo set_select('difficulte', '5'); ?>>5</option></select>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="nbr_intervenants">Nombre de consultants requis</label>
                    <div class="controls">
                        <select id="nbr_intervenants" name="nbr_intervenants"><option value="1" <?php echo set_select('nbr_intervenants', '1'); ?>>1</option><option value="2" <?php echo set_select('nbr_intervenants', '2'); ?>>2</option><option value="3" <?php echo set_select('nbr_intervenants', '3'); ?>>3</option><option value="4" <?php echo set_select('nbr_intervenants', '4'); ?>>4</option><option value="5" <?php echo set_select('nbr_intervenants', '5'); ?>>5</option><option value="6" <?php echo set_select('nbr_intervenants', '6'); ?>>6</option><option value="7" <?php echo set_select('nbr_intervenants', '7'); ?>>7</option><option value="8" <?php echo set_select('nbr_intervenants', '8'); ?>>8</option></select>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="details_recherche">Détails de la mission</label>
                    <div class="controls">
                        <textarea name="details_recherche" id="details_recherche" rows="5" cols="3"><?php echo set_value('details_recherche', '...'); ?></textarea>
                    </div>
                </div>


                <div class="control-group">
                    <label class="control-label" for="fichiers">Document</label>
                    <div class="controls">
                        <span class="btn btn-file"><input type="file" name="fichiers" id="fichiers"/></span>
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

        <!-- Modal Delete Recherche de Comp -->
        <div id="delete-recherche" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="recherche-delete-title" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="recherche-delete-title">Supprimer cette recherche de compétences ?</h3>
            </div>
            <br/>
            <div class="modal-body">
                Voulez-vous vraiment supprimer cette recherche de compétences ?

            </div>
    <?php echo form_open('admin_recherches/delete'); ?>
                <div class="modal-footer">

                    <input type="hidden" name="recherche-delete" id="recherche-delete" value="">
                    <button class="btn btn-primary" type="submit">Oui</button>
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Non</button>
                </div>
            </form>
            </div>


<?php echo (isset($modal) && $modal == TRUE) ? "<script>$('#add-recherche').modal('show');</script>" : "" ?>