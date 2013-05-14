<!-- En-tete -->
<div class="row-fluid">
    <div class="span18 offset2 well ">

        <h3><img alt="stages" src="<?php echo base_url('assets/img/Briefcase.png') ?>">
            Offres de stages</h3>
    </div>

</div>
<!-- Corps -->
<div class="row-fluid">
    <!-- 1ere colonne -->
    <div class="span18 offset2" >
        <table class="table table-striped table-bordered table-hover ">
            <thead><tr><th>Poste</th><th>Société</th><th>Compétence(s) requise(s)</th><th>Durée</th><th>Posté le</th><th>Document(s)</th><th>Détails</th></tr></thead>
            <tbody>
                <?php
                for ($i = 0; $i < $nbr_stages; $i++) {
                    echo'<tr><td>' . $info[$i]['poste'] . '</td><td>' . $info[$i]['societe'] . '</td><td>' . $info[$i]['competences'] . '</td><td style="text-align:center;">' . ($info[$i]['duree']) . '</td><td style="text-align:center;">' . formatDate($info[$i]['date']) . '</td><td style="text-align:center;">' . documents($info[$i]['fichiers']) . '</td><td style="text-align:center;"><a onmouseout="$(this).popover(\'hide\');" onmouseover="$(this).popover({content:\'' . str_replace('"', "\'", str_replace("'", "\'", $info[$i]['details_stage'])) . '\'});$(this).popover(\'show\');" href="" data-html="TRUE" data-toggle="popover" data-placement="bottom" data-original-title="Détails de l\'offre de stage"><i class="icon icon-search"></i></a></td></tr>';
                }
                                if ($nbr_stages == 0) {
                    echo'<tr><td colspan="7">Aucune offre de stage pour le moment</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
