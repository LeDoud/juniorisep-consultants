<?php
$userdata = $this->session->all_userdata();
if (isset($userdata['logged_in']) && $userdata['logged_in'] == TRUE) {
?>
    <!-- Footer -->
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
<!-- Google Analytics -->
<script type="text/javascript">

    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-39593613-1']);
    _gaq.push(['_trackPageview']);

    (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();

</script>
</html>
