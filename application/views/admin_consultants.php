<!-- Corps -->
<div class="row-fluid">
    <div class="span18 offset2 well ">

        <h3><img alt="consultants" src="<?php echo base_url('assets/img/Name_Card.png') ?>">
            Liste des utilisateurs</h3>
    </div>
</div>
<div class="row-fluid">
    <!-- 1ere colonne -->
    <div class="span18 offset2" data-offset="50" data-spy="scroll" style="max-height: 500px;overflow: auto;position: relative; ">
        <?php echo validation_errors(); ?>
        <table class="table table-striped table-bordered table-hover">
            <thead><tr><th  style="text-align:center">Nom</th><th  style="text-align:center">Prénom</th><th  style="text-align:center">Login</th><th  style="text-align:center">Email</th><th  style="text-align:center">Téléphone</th><th  style="text-align:center">Promotion</th><th  style="text-align:center">Statut</th><th  style="text-align:center">Compétences</th></tr></thead>
            <tbody>
                <?php
                for ($i = 0; $i < $nbr_consultants; $i++) {
                    if ($info[$i]['role'] == 'consultant') {
                        $select = form_open('admin_consultants/change', array('class' => 'form-horizontal')) . '<select id="role" name="role" class="input-medium" onchange="this.form.submit();"><option value="isepien" >isépien</option><option value="consultant" selected>consultant</option></select><input type="hidden" name="thislogin" id="thislogin" value="' . $info[$i]['login'] . '"></form>';
                    } else if ($info[$i]['role'] == 'admin') {
                        $select = 'admin';
                    } else {
                        $select = form_open('admin_consultants/change', array('class' => 'form-horizontal')) . '<select id="role" name="role" class="input-medium" onchange="this.form.submit();"><option value="isepien" selected>isépien</option><option value="consultant" >consultant</option></select><input type="hidden" name="thislogin" id="thislogin" value="' . $info[$i]['login'] . '"></form>';
                    }
                    echo '<tr><td style="text-align:center">' . $info[$i]['nom'] . '</td><td style="text-align:center">' . $info[$i]['prenom'] . '</td><td style="text-align:center">' . $info[$i]['login'] . '</td><td style="text-align:center">' . $info[$i]['email'] . '</td><td style="text-align:center">' . $info[$i]['tel'] . '</td><td style="text-align:center">' . $info[$i]['promotion'] . '</td><td style="text-align:center">' . $select . '</td><td style="text-align:center"><a data-placement="left" data-toggle="tooltip" onmouseout="$(this).tooltip(\'hide\');" onmouseover="$(this).tooltip(\'show\');" data-original-title="Voir son profil détaillé" href="details/' . $info[$i]['login'] . '"><i class="icon icon-search"></i></a></td></tr>';
                }
                ?>
            </tbody>
        </table>


    </div></div>