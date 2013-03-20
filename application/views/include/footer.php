<?php
$userdata = $this->session->all_userdata();
if (isset($userdata['logged_in']) && $userdata['logged_in'] == TRUE) {
?>
    <div id="content-bas" class="container-fluid">    
        <div class="row-fluid"></div>
        <div class="row-fluid"></div>
    </div>
    <footer id="content-info" class="container-fluid" role="contentinfo">
        <p>Copyright &copy; <?php echo (date('Y') == '2013') ? '2013' : '2013 - ' . date('Y'); ?> <a href="http://www.juniorisep.com" target="_blanck">Junior ISEP</a> : la Junior-Entreprise de l'ISEP | <a href="mailto:assistance@juniorisep.com">Assistance technique</a></p>
        <div class="row-fluid"></div>
        <div class="row-fluid"></div>
    </footer>
<?php } ?>
</body>
</html>
