<!-- En-tete -->
<div class="row-fluid">
    <div class="span18 offset2 well ">

        <h3><img src="<?php echo base_url('assets/img/Clipboard.png') ?>">
            Formations</h3>
    </div>

</div>
<!-- Corps -->
<div class="row-fluid">
    <!-- 1ere colonne -->
    <div class="span18 offset2">
        <table class="table table-striped table-bordered table-hover">
            <thead><tr><th>Intitulé</th><th>Lieu</th><th>Date</th><th>Intervenants</th><th>Document(s)</th><th>Inscription</th><th>Détails</th></tr></thead>
            <tbody>
                <?php
                for ($i = 0; $i < $nbr_formations; $i++) {
                    echo'<tr><td>' . $info[$i]['nom_formation'] . '</td><td>' . $info[$i]['lieu'] . '</td><td>' . formatDate($info[$i]['date']) . '</td><td>' . $info[$i]['intervenants'] . '</td><td style="text-align:center;">' . ((checkConsultant($info[$i]['id_formation'], $userdata_id) == TRUE) ? documents($info[$i]['fichiers']) : documents()) . '</td><td style="text-align:center;">' . ((checkConsultant($info[$i]['id_formation'], $userdata_id) == TRUE) ? 'Inscrit!' : '<a data-placement="top" data-toggle="modal" onmouseout="$(this).tooltip(\'hide\');" onmouseover="$(this).tooltip(\'show\');document.getElementById(\'formation-sign\').value=\'' . encrypt($info[$i]['id_formation']) . '\'" data-original-title="M’inscrire" href="#sign-formation"><i class="icon icon-flag"></i></a>') . '</td><td style="text-align:center;"><a onmouseout="$(this).popover(\'hide\');" onmouseover="$(this).popover(\'show\');" href="" data-html="TRUE" data-toggle="popover" data-placement="bottom" data-content="' . $info[$i]['details_formation'] . '" data-original-title="Détails de la formation"><i class="icon icon-search"></i></a></td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<!-- Modal Sign In Formation -->
<div id="sign-formation" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="sign-title" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="sign-title">Inscription à la formation</h3>
    </div>
    <br/>
    <div class="modal-body">
        Voulez-vous vraiment vous inscrire à cette formation ?

    </div>
    <?php echo form_open('formation/register'); ?>
    <div class="modal-footer">

        <input type="hidden" name="formation-sign" id="formation-sign" value="">
        <button class="btn btn-primary" type="submit">Oui</button>
        <button class="btn" data-dismiss="modal" aria-hidden="true">Non</button>
    </div>
</form>
</div>