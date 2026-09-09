<html lang="en">
    <?php
    $accountYearDetails = loginBlock::loginAccountYear();
    $companyDetails = loginBlock::getCompanyDetails();
    $companyName = (array) $companyDetails;
    ?>
    <head>
        <?php self::loadDesign('template/metaData'); ?>
        <title> Mahilchi Associate </title>
        <!-- Favicons-->
        <link rel="icon" href="<?php echo URL; ?>assets/img/favicon/BeeBook.png" sizes="32x32">
        <!-- Bootstrap -->
        <style>
            html{display: table;margin: auto;}
        </style>
        <?php self::loadDesign('template/cssLinks'); ?>
        <?php self::loadDesign('template/scriptlinkslogin'); ?>
        <script type="text/javascript" src="<?php echo URL; ?>assets/js/billbee.js"></script>
        <script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
        <script type="text/javascript" src="<?php echo URL; ?>assets/js/customer/newCustomer.js"></script>
        <script type="text/javascript" src="<?php echo URL; ?>assets/js/global/location.js"></script>
        <script type="text/javascript" src="<?php echo URL; ?>assets/js/reports/reports.js"></script>
        <link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
    </head>
    <body class="teal">
        <!-- Start Page Loading -->
        <!--<div id="loader-wrapper">
            <div id="loader"></div>        
            <div class="loader-section section-left"></div>
            <div class="loader-section section-right"></div>
        </div>-->
        <div id="login-page" class="row">
            <div class="col s12 z-depth-4 card-panel">
                <form class="login-form">
                    <div class="row">
                        <div class="input-field col s12 center">
                            <img src="<?php echo URL; ?>assets/img/favicon/BeeBook.png" alt="" class='circle responsive-img valign profile-image-login'>
                            <p class="center login-form-text">The BeeBook</p>
                        </div>
                    </div>
                    <div class="row margin">
                        <div class="input-field col s12">
                            <i class="mdi-social-person-outline prefix"></i>
                            <input id="username" name="username" type="text">
                            <label for="username" class="center-align">Username</label>
                        </div>
                    </div>
                    <div class="row margin">
                        <div class="input-field col s12">
                            <i class="mdi-action-lock-outline prefix"></i>
                            <input id="password" name="password" type="password">
                            <label for="password">Password</label>
                        </div>
                    </div>
                    <div class="row margin">
                        <div class="input-field col s12">
                            <div class="input-group">
                                <label for="firmName" class="active">Firm Name</label>
                                <div class="sel-wrap">
                                    <select id="firmName" name="firmName" class="floating-label">
                                        <option value="" disabled selected>Select Firm</option>
                                        <?php echo loginBlock::getCompanyDetails(''); ?>           
                                    </select>

                                    <div class='bar'></div>
                                </div>  
                            </div>
                            <script>
                                floatingSelect2('firmName');
                            </script>
                        </div>
                    </div>
                    <div class="row margin">
                        <div class="input-field col s12">
                            <div class="input-group">
                                <label for="accountingYear" class="active">Year</label>
                                <div class="sel-wrap">
                                    <select id="accountingYear" name="accountingYear" class="floating-label">
                                        <option value="" disabled selected>Select Year</option>
                                        <?php echo loginBlock::loginAccountYear(1); ?>          
                                        <!-- <option value="1" >2017-2018</option>-->
                                    </select>
                                    <div class='bar'></div>
                                </div>  
                            </div>
                            <script>
                                floatingSelect2('accountingYear');
                            </script>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <!--<a href="#!" class="btn waves-effect waves-light col s12">Login</a>-->
                            <button type="button" class="btn waves-effect waves-light col s12" onclick="getLoginDetails()">Login</button>
                        </div>
                    </div>
                    <!--<div class="row">
                        <div class="input-field col s6 m6 l6">
                            <p class="margin medium-small"><a href="page-register.html">Register Now!</a></p>
                        </div>
                        <div class="input-field col s6 m6 l6">
                            <p class="margin right-align medium-small"><a href="page-forgot-password.html">Forgot password ?</a></p>
                        </div>          
                    </div>-->

                </form>
            </div>
        </div>
        <div id="loadLogin">
        </div>
    </body>
</html>

