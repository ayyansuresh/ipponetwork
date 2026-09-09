
<!DOCTYPE html>

<html lang="en">
    <head>
        <?php self::loadDesign('template/metaData'); ?>
        <title>IPPO Network</title>
        <!-- Favicons-->

        <link rel="icon" href="<?php echo URL; ?>assets/img/favicon/BeeBook.png" sizes="32x32">
        <!-- Bootstrap -->
        <?php self::loadDesign('template/cssLinks'); ?>
        
    </head>
    <body>
        <!-- Start Page Loading -->
        <div id="loader-wrapper">
            <div id="loader"></div>        
            <div class="loader-section section-left"></div>
            <div class="loader-section section-right"></div>
        </div>
        <?php
        if (client_Live == client_Common) {
            self::loadDesign('template/header');
        } else {
            self::loadDesign('template/' . client_folder . '/header');
        }
        ?>
        <?php self::loadDesign('template/scriptLinks');
        date_default_timezone_set('Asia/Kolkata');?>
        <div id="main">
            <div class="wrapper">
                <?php
                self::loadDesign('template/leftSideBar');
                $loginUserId = generalhelper::getSessionElement('beebookloginuserid');
                
               
                
                ?>
                <div id="beeprocessor">
                    <?php if ($loginUserId == 1) { ?>
                        <div id="loader-wrapper">
                            <div id="loader"></div>        
                            <div class="loader-section section-left"></div>
                            <div class="loader-section section-right"></div>
                        </div>
                        <section id="content">
                            <!--start container-->
                            <div class="container">

                                <!--chart dashboard start-->
                                <div id="chart-dashboard">
                                    <div class="row">
                                        <div class="col s12 m8 l8">
                                            <?php
                                            if (client_Live == '15' || client_Live == '20') {
                                                self::loadDesign('dashboard/salesgraph');
                                            }
                                            ?>
                                        </div>

                                        <div class="col s12 m4 l4">
                                            <?php
                                            if (client_Live == '15' || client_Live == '20') {
                                                self::loadDesign('dashboard/itemgraph');
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <?php
                                if (client_Live == '15' || client_Live == '20') {
                                    self::loadDesign('dashboard/cardstatstics');
                                }
                               
//                                self::loadBlock('customer/customerBlock');
//                                self::loadBlock('item/itemBlock');
//                                self::loadBlock('account/accountBlock');
//                                self::loadBlockSales('sales/' . client_folder . '/salesInvoiceBlock');
//                                self::loadDesign('sales/' . client_folder . '/salesInvoiceEntry');
                                ?>
                                <script>
                                    loadSalesBillForm(1, 0);

                                </script>
                            </div>
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <?php self::loadDesign('template/footer'); ?>
                        </section>
                                               <?php
                    } else {
                        ?>
                        <script>
                            loadRetailForm(3, 0);

                        </script>
                        <?php
                    }
                    ?>
                </div>
                <?php self::loadDesign('template/rightSideBar'); ?>
            </div>
        </div>

        <?php self::loadDesign('popup/generalPopUp'); ?>
        <?php //self::loadDesign('template/footer');   ?>

    </body>
    <?php
        
    ?>

</html>
