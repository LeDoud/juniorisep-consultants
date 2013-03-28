<!-- En-tete -->
<div class="row-fluid">
    <div class="span18 offset2 well ">

        <h3><img alt="missions" src="<?php echo base_url('assets/img/Wallet.png') ?>">
            Recherche de compétences</h3>
    </div>

</div>
<!-- Corps -->
<div class="row-fluid">
    <!-- 1ere colonne -->
    <div class="span18 offset2" >
        <table class="table table-striped table-bordered table-hover ">
            <thead><tr><th>Priorité</th><th>Type</th><th>Compétence(s) requise(s)</th><th>Difficulté</th><th>Consultant(s) requis</th><th>Chef de Projet</th><th>Posté le</th><th>Document(s)</th><th>Postuler</th><th>Détails</th></tr></thead>
            <tbody>
                <?php
                for ($i = 0; $i < $nbr_recherches; $i++) {
                    echo'<tr><td>' . $info[$i]['priorite'] . '</td><td>' . $info[$i]['type'] . '</td><td>' . $info[$i]['competences'] . '</td><td>' . notation($info[$i]['difficulte']) . '</td><td style="text-align:center;">' . ($info[$i]['nbr_intervenants']) . '</td><td style="text-align:center;">' . respo($info[$i]['id_cdp']) . '</td><td style="text-align:center;">' . formatDate($info[$i]['date']) . '</td><td style="text-align:center;">' . documents($info[$i]['fichiers']) . '</td><td style="text-align:center;">' . postuler($role, $info[$i]['id_recherche'], $userdata_id) . '</td><td style="text-align:center;"><a onmouseout="$(this).popover(\'hide\');" onmouseover="$(this).popover({content:\'' . str_replace('"', "\'", str_replace("'", "\'", $info[$i]['details_recherche'])) . '\'});$(this).popover(\'show\');" href="" data-html="TRUE" data-toggle="popover" data-placement="bottom" data-original-title="Détails de la mission"><i class="icon icon-search"></i></a></td></tr>';
                }
                                if ($nbr_recherches == 0) {
                    echo'<tr><td colspan="10">Aucune mission pour le moment</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<?php if ($role != 'isepien') {
?>
                    <!-- Modal Postulate Mission -->
                    <div id="post-recherche" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="post-title" aria-hidden="true">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h3 id="post-title">Postuler à la mission</h3>
                        </div>
                        <br/>
                        <div class="modal-body">
                            <p>Pour postuler à cette mission, veuillez remplir le champ ci-dessous :</p><br/>
        <?php echo validation_errors(); ?>
        <?php echo form_open('recherche/postulate', array('class' => 'form-horizontal')); ?>


                    <div class="control-group">
                        <label class="control-label" for="motivation">Votre motivation pour postuler à cette mission : (50 caractères minimum)</label>
                        <div class="controls">
                            <textarea name="motivation" id="motivation" rows="10" cols="10" placeholder="Expliquez en quelques mots votre motivation..."><?php echo set_value('motivation'); ?></textarea>
                        </div>
                    </div>
                    <input type="hidden" name="recherche-post" id="recherche-post" value="<?php echo (!empty($id_mission)) ? $id_mission : ""; ?>">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Envoyer</button>
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Annuler</button>
                </div>
            </form>
            </div>

<?php echo (isset($modal) && $modal == TRUE) ? "<script>$('#post-recherche').modal('show');</script>" : "" ?>

<?php } ?>