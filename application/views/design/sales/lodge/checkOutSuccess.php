<?php
$salesBillId = generalhelper::getGetElement('billRefId');
$salesUpdateFlag = generalhelper::getGetElement('salesUpdateFlag');
?>
<div class="modal-content">
    <div class="row">
        <div class="col s12 m12 l12">
            <div class="card-panel">
                <h4 class="header2">SUCCESS MESSAGE</h4>
                <div class="row">
                    <form class="col s12">
                        <h4> <label>Check Out Details Inserted Successfully </label></h4>
                        <form>
                            </div>
                            </div>
                            </div>
                            </div>
                            </div>
                            <div class="modal-footer green lighten-4">
                                <?php if ($salesUpdateFlag == 1) { ?>
                                    <button  class="waves-effect waves-red btn-flat modal-action" onclick="closeCheckOutDetails();">Close</button>
                                <?php } else { ?>
                                    <button  class="waves-effect waves-red btn-flat modal-action" onclick="closeCheckInDetails('<?php echo $salesBillId; ?>');">Close</button>
                                <?php }
                                ?>

                            </div>

