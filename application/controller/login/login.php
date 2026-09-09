<?php

class login extends Controller {

    public function index() {
        ?>
        <script> window.location = "<?php echo URL; ?>login-login/userlogin";</script>
        <?php
    }

    
}
