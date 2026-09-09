
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/jquery-1.11.2.min.js"></script> 
<!--materialize js-->
<script type="text/javascript" src="<?php echo URL; ?>assets/js/billBee.js"></script>

<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.js"></script>
<!--scrollbar-->
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>


<!-- chartist 
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/chartist-js/chartist.min.js"></script> -->  

<!-- chartjs -->
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/chartjs/chart.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/chartjs/chart-script.js"></script>

<!-- sparkline -->
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/sparkline/jquery.sparkline.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/sparkline/sparkline-script.js"></script>

<!-- google map api 
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAAZnaZBXLqNBRXjd-82km_NO7GUItyKek"></script>

<!--jvectormap--
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/jvectormap/vectormap-script.js"></script>    
-->

<!--plugins.js - Some Specific JS codes for Plugin Settings-->
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<!-- Toast Notification -->

<?php
if (client_Live == client_Common) {
    ?>
    <script type="text/javascript" src="<?php echo URL; ?>assets/js/global/globalLinks.js"></script>
    <?php
} else {
    ?>
    <script type="text/javascript" src="<?php echo URL; ?>assets/js/global/malleswaraglobalLinks.js"></script>
    <?php
}
?>
<script type = "text/javascript" src = "<?php echo URL; ?>assets/js/pmd/select2.full.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/pmd/pmd-select2.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/pmd/textfield.js"></script>
<script>
    $(document).ready(function () {
        $(".button-collapse").sideNav();
    });
</script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/jquery.validate.min.js"></script>
