<div style="width: 500px; margin: 0 auto;">
    <h3> Bienvenue sur l'espace consultant !</h3>
    <div class="alert alert-info">Ceci est votre première connexion, nous vous demandons de renseigner certaines informations sur vous avant de continuer :</div>
    <?php echo validation_errors(); ?>
    <?php echo form_open('user/firstime', array('class' => 'form-horizontal')); ?>

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
            <input type="text" id="prenom" name="prenom" placeholder="Prénom" value="<?php echo set_value('prenom'); ?>">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="nom">Nom</label>
        <div class="controls">
            <input type="text" id="nom" name="nom" placeholder="Nom" value="<?php echo set_value('nom'); ?>">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="promo">Promotion</label>
        <div class="controls">
            <select class="span2" id="promo" name="promo" >
                <?php
                for ($i = 0; $i < 6; $i++) {
                    echo'<option value="' . (date('Y') + $i) . '">' . (date('Y') + $i) . '</option>';
                } ?>
            </select>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="naissance">Date de naissance</label>
        <div class="controls">
            <div class="input-append date" id="dpYears" data-date="1992-01-01" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
                <input class="span3" id="naissance" name="naissance" size="16" type="text" value="<?php echo set_value('naissance'); ?>" readonly="">
                <span class="add-on"><i class="icon-calendar"></i></span>
            </div>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="tel">Téléphone</label>
        <div class="controls">
            <input type="text" id="tel" name="tel" placeholder="Numéro de téléphone" value="<?php echo set_value('tel'); ?>">
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
            <button type="submit" class="btn btn-primary">Mettre à jour mes informations</button>
        </div>
    </div>
</form>
</div>
<script>
    $('#dpYears').datepicker();
</script>