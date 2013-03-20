<div id="login">
    <?php echo form_open('home/login', array('class' => '')) ?>
    <h3> <?= $title ?> </h3>
    <label for="login">login</label>
    <input type="input" name="login" class="input-medium" placeholder="login ISEP"/><br /><br />

    <label for="pwd">mot de passe</label>
    <input type="password" name="pwd" class="input-medium" placeholder="mot de passe"/><br />

    <input type="submit" name="submit" value="Connexion" class="btn btn-primary"/>

</form>
</div>
<?php echo (!empty($message)) ? '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>' . $message . '</div>' : ''; ?>

