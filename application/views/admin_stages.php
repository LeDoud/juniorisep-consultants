<!-- En-tete -->
<div class="row-fluid">
    <div class="span20 offset2 well ">

        <h3><img alt="stage" src="<?php echo base_url('assets/img/Briefcase.png') ?>">
            Administration - Offres de stages</h3>
    </div>

</div>
<!-- Corps -->
<div class="row-fluid">
    <!-- 1ere colonne -->
    <div class="span20 offset2">
        <table class="table table-striped table-bordered table-hover ">
            <thead><tr><th>Poste</th><th>Société</th><th>Compétence(s) requise(s)</th><th>Durée</th><th>Posté le</th><th>Document(s)</th><th>Visible ?</th><th>Editer</th><th>Détails</th></tr></thead>
            <tbody>
                <?php
                for ($i = 0; $i < $nbr_stages; $i++) {
                    if ($info[$i]['dispo'] == 'oui') {
                        $select = form_open('admin_stages/change', array('class' => 'form-horizontal')) . '<select id="dispo" name="dispo" class="input-small" onchange="this.form.submit();"><option value="oui" selected>oui</option><option value="non">non</option></select><input type="hidden" name="thisstage" id="thisstage" value="' . $info[$i]['id_stage'] . '"></form>';
                    } else {
                        $select = form_open('admin_stages/change', array('class' => 'form-horizontal')) . '<select id="dispo" name="dispo" class="input-small" onchange="this.form.submit();"><option value="oui" >oui</option><option value="non" selected>non</option>></select><input type="hidden" name="thisstage" id="thisstage" value="' . $info[$i]['id_stage'] . '"></form>';
                    }
                    echo'<tr><td>' . $info[$i]['poste'] . '</td><td>' . $info[$i]['societe'] . '</td><td>' . $info[$i]['competences'] . '</td><td>' . $info[$i]['duree'] . '</td><td style="text-align:center;">' . formatDate($info[$i]['date']) . '</td><td style="text-align:center;">' . documents($info[$i]['fichiers']) . '</td><td>' . $select . '</td><td style="text-align:center;"><a data-placement="top" onmouseout="$(this).tooltip(\'hide\');" onmouseover="$(this).tooltip(\'show\');' . update_stage($info[$i]) . '" href="#update-stage" data-toggle="modal" data-original-title="Modifier" ><i class="icon-edit"></i></a>&nbsp;&nbsp;<a data-placement="top" onmouseout="$(this).tooltip(\'hide\');" onmouseover="$(this).tooltip(\'show\');document.getElementById(\'stage-delete\').value=' . $info[$i]['id_stage'] . '" href="#delete-stage" data-toggle="modal" data-original-title="Supprimer"><i class="icon icon-trash"></i></a></td><td style="text-align:center;"><a onmouseout="$(this).popover(\'hide\');" onmouseover="$(this).popover({content:\'' . str_replace('"', "\'", str_replace("'", "\'", $info[$i]['details_stage'])) . '\'});$(this).popover(\'show\');" href="" data-toggle="popover" data-placement="bottom"  data-html="TRUE" data-original-title="Détails de l\'offre de stage"><i class="icon icon-search"></i></a></td></tr>';
                }
                if ($nbr_stages == 0) {
                    echo'<tr><td colspan="9">Aucune offre de stage pour le moment</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

</div>
<br/><br/>
<div class="row-fluid">
    <div class="offset2">
        <a href="#add-stage" role="button" class="btn btn-primary" data-toggle="modal">Ajouter une offre de stage</a>
    </div>
</div>

<!-- Modal Add Stage -->
<div id="add-stage" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="stage-title" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="stage-title">Nouvelle offre de stage</h3>
    </div>
    <br/>
    <div class="modal-body">
        <?php echo validation_errors(); ?>
        <?php echo isset($error) ? $error : ''; ?>
        <?php echo form_open_multipart('admin_stages/add', array('class' => 'form-horizontal')); ?>

                <div class="control-group">
                    <label class="control-label" for="poste">Poste</label>
                    <div class="controls">
                        <input name="poste" id="poste" placeholder="Poste" value="<?php echo set_value('poste'); ?>">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="societe">Société</label>
                    <div class="controls">
                        <input name="societe" id="societe" placeholder="Société" value="<?php echo set_value('societe'); ?>">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="competences">Compétences requises</label>
                    <div class="controls">
                        <input name="competences" id="competences" placeholder="ex: HTML/CSS & PHP/MySQL" value="<?php echo set_value('competences'); ?>">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="duree">Durée du stage</label>
                    <div class="controls">
                        <input name="duree" id="duree" placeholder="ex : 6 mois" value="<?php echo set_value('duree'); ?>">
                    </div>
                </div>


                <div class="control-group">
                    <label class="control-label" for="details_stage">Détails de l'offre de stage</label>
                    <div class="controls">
                        <textarea name="details_stage" id="details_stage" rows="5" cols="3" placeholer="Résumé de l'offre de stage"style="width: 320px; height: 320px"><?php echo set_value('details_stage', ''); ?></textarea>
                    </div>
                </div>


                <div class="control-group">
                    <label class="control-label" for="fichiers">Document (pdf ou zip)</label>
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

        <!-- Modal Update Stage -->
        <div id="update-stage" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="stage-title" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="stage-title">Mettre à jour l'offre de stage</h3>
            </div>
            <br/>
            <div class="modal-body">
        <?php echo validation_errors(); ?>
        <?php echo isset($error) ? $error : ''; ?>
        <?php echo form_open_multipart('admin_stages/update', array('class' => 'form-horizontal')); ?>
                <input type="hidden" name="id-stage-update" id="id-stage-update" value="<?php echo set_value('id-stage-update'); ?>">
                <div class="control-group">
                    <label class="control-label" for="poste-update">Poste</label>
                    <div class="controls">
                        <input name="poste-update" id="poste-update" placeholder="Poste" value="<?php echo set_value('poste-update'); ?>">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="societe-update">Société</label>
                    <div class="controls">
                        <input name="societe-update" id="societe-update" placeholder="" value="<?php echo set_value('societe-update'); ?>">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="competences-update">Compétences requises</label>
                    <div class="controls">
                        <input name="competences-update" id="competences-update" placeholder="ex: HTML/CSS & PHP/MySQL" value="<?php echo set_value('competences-update'); ?>">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="duree-update">Durée du stage</label>
                    <div class="controls">
                        <input name="duree-update" id="duree-update" placeholder="ex : 6 mois" value="<?php echo set_value('duree-update'); ?>">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="details_stage-update">Détails de l'offre</label>
                    <div class="controls">
                        <textarea name="details_stage-update" id="details_stage-update" rows="5" cols="3" placeholer="Résumé de l'offre de stage"style="width: 320px; height: 320px"><?php echo set_value('details_stage-update', ''); ?></textarea>
                    </div>
                </div>


                <div class="control-group">
                    <label class="control-label" for="fichiers-update">Document (pdf ou zip) &nbsp;&nbsp;&nbsp;&nbsp;( <i class="icon icon-warning-sign"></i> Ceci remplacera les documents précédents!)</label>
                    <div class="controls">
                        <span class="btn btn-file"><input type="file" name="fichiers-update" id="fichiers-update"/></span>
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls">
                        <button type="submit" class="btn btn-primary">Modifier</button>
                    </div>
                </div>
                </form>
            </div>
        </div>

        <!-- Modal Delete Stage -->
        <div id="delete-stage" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="stage-delete-title" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="stage-delete-title">Supprimer cette offre de stage ?</h3>
            </div>
            <br/>
            <div class="modal-body">
                Voulez-vous vraiment supprimer cette offre de stage ?

            </div>
    <?php echo form_open('admin_stages/delete'); ?>
                <div class="modal-footer">

                    <input type="hidden" name="stage-delete" id="stage-delete" value="">
                    <button class="btn btn-primary" type="submit">Oui</button>
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Non</button>
                </div>
            </form>
            </div>


<?php echo (isset($modal) && $modal == TRUE) ? "<script>$('#add-stage').modal('show');</script>" : "" ?>
<?php echo (isset($modal2) && $modal2 == TRUE) ? "<script>$('#update-stage').modal('show');</script>" : "" ?>
                <script src="<?php echo base_url('assets/js/wysihtml5-0.3.0.js') ?>"></script>
                <script src="<?php echo base_url('assets/js/bootstrap-wysihtml5.js') ?>"></script>
<script>
    $('#details_stage').wysihtml5();
    var editor = $('#details_stage-update').wysihtml5();
    function appendEditor(text){
        var editorInstance = editor.data('wysihtml5').editor;
        editorInstance.setValue(text, true);
    }
</script>