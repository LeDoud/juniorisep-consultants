<!-- En-tete -->
<div class="row-fluid">
    <div class="span16 offset2 well ">

        <h3><img src="<?php echo base_url('assets/img/Clipboard.png') ?>">
            Administration - Formations</h3>
    </div>

</div>
<!-- Corps -->
<div class="row-fluid">
    <!-- 1ere colonne -->
    <div class="span16 offset2">
        <table class="table table-striped table-bordered table-hover">
            <thead><tr><th>Intitulé</th><th>Lieu</th><th>Date</th><th>Intervenants</th><th>Document(s)</th><th>Consultant(s) inscrit(s)</th><th>Supprimer</th><th>Détails</th></tr></thead>
            <tbody>
                <?php
                for ($i = 0; $i < $nbr_formations; $i++) {
                    echo'<tr><td>' . $info[$i]['nom_formation'] . '</td><td>' . $info[$i]['lieu'] . '</td><td>' . formatDate($info[$i]['date']) . '</td><td>' . $info[$i]['intervenants'] . '</td><td style="text-align:center;">' . documents($info[$i]['fichiers']) . '</td><td style="text-align:center;">' . getListConsultants($info[$i]['id_formation']) . '</td><td style="text-align:center;"><a data-placement="top" onmouseout="$(this).tooltip(\'hide\');" onmouseover="$(this).tooltip(\'show\');document.getElementById(\'formation-delete\').value=' . $info[$i]['id_formation'] . '" href="#delete-formation" data-toggle="modal" data-original-title="Supprimer" ><i class="icon-trash"></i></a></td><td style="text-align:center;"><a onmouseout="$(this).popover(\'hide\');" onmouseover="$(this).popover({content:\'' . str_replace('"', '’', str_replace("'", "’", $info[$i]['details_formation'])) . '\'});$(this).popover(\'show\');" href="" data-toggle="popover" data-placement="right"  data-html="TRUE"  data-original-title="Détails de la formation"><i class="icon icon-search"></i></a></td></tr>';
                }
                ?>
            </tbody>
        </table>
        <a href="#add-formation" role="button" class="btn btn-primary" data-toggle="modal">Ajouter une formation</a>
        <br/>
        <br/>
    </div>
</div>
<!-- Modal Add Formation -->
<div id="add-formation" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="formation-title" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="formation-title">Nouvelle formation</h3>
    </div>
    <br/>
    <div class="modal-body">
        <?php echo validation_errors(); ?>
        <?php echo isset($error) ? $error : ''; ?>
        <?php echo form_open_multipart('admin_formations/add', array('class' => 'form-horizontal')); ?>

                <div class="control-group">
                    <label class="control-label" for="nom">Nom de la formation</label>
                    <div class="controls">
                        <input name="nom" id="nom" placeholder="Nom de la formation" value="<?php echo set_value('nom'); ?>">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="lieu">Lieu de la formation</label>
                    <div class="controls">
                        <input name="lieu" id="lieu" placeholder="Lieu de la formation" value="<?php echo set_value('lieu'); ?>">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="date">Date de la formation</label>
                    <div class="controls">
                        <div class="input-append date" id="dpYears" data-date=""  data-format="yyyy-MM-dd hh:mm:ss" data-date-viewmode="months">
                            <input class="span4 input-append date" data-format="yyyy-MM-dd hh:mm:ss" id="date" name="date" size="24" type="text" value="<?php echo set_value('date'); ?>" readonly="">
                            <span class="add-on"><i class="icon-calendar"></i></span>
                        </div>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="intervenants">Intervenants</label>
                    <div class="controls">
                        <input name="intervenants" id="intervenants" placeholder="Intervenants" value="<?php echo set_value('intervenants'); ?>">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="details-formation">Détails de la formation</label>
                    <div class="controls">
                        <textarea name="details-formation" id="details-formation" rows="5" cols="3"><?php echo set_value('details-formation', ''); ?></textarea>
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

        <!-- Modal Delete Formation -->
        <div id="delete-formation" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="formation-title" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="formation-title">Supprimer cette formation ?</h3>
            </div>
            <br/>
            <div class="modal-body">
                Voulez-vous vraiment supprimer cette formation ?

            </div>
    <?php echo form_open('admin_formations/delete'); ?>
                <div class="modal-footer">

                    <input type="hidden" name="formation-delete" id="formation-delete" value="">
                    <button class="btn btn-primary" type="submit">Oui</button>
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Non</button>
                </div>
            </form>
            </div>


<?php echo (isset($modal) && $modal == TRUE) ? "<script>$('#add-formation').modal('show');</script>" : "" ?>
                <script src="<?php echo base_url('assets/js/wysihtml5-0.3.0.js') ?>"></script>
                <script src="<?php echo base_url('assets/js/bootstrap-wysihtml5.js') ?>"></script>
<script>
    $('#dpYears').datetimepicker();
    $('#details-formation').wysihtml5();
</script>