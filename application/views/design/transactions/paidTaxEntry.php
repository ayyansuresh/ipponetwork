<script type="text/javascript" src="<?php echo URL; ?>assets/js/transaction/transaction.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/payment/payment.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/paymentMode.css">
<script type="text/javascript" src="<?php echo URL; ?>assets/js/payment/easyResponsiveTabs.js"></script>
<style>
    .picker__month-display{font-size: 1rem !important;}.picker__day-display{font-size: 2.5rem !important;}.picker__year-display{font-size: 1.5rem !important;}select.browser-default{margin-left: 1rem;}.picker__holder{margin-top:-5%;}
</style>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.datepicker').pickadate({
            selectMonths: true, // Creates a dropdown to control month
            selectYears: 15,
            formatSubmit: 'yyyy/mm/dd',
            format: 'yyyy-mm-dd',
            onSet: function (ele) {
                if (ele.select) {
                    this.close();
                }
            }
            // Creates a dropdown of 15 years to control year
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#paidTaxEntry").materialvalidation({
            theme: "materialize"
        });
        $("#paidTaxEntry").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#paidTaxEntry").data().materialvalidation.methods.validate()) {
                makePaidTaxEntry();
            }
            return false;
        });
    });
</script>
<form id="paidTaxEntry">
    <div class="container teal lighten-2">
        <input id="transactionType" type="hidden" value="0">
        <div class="collection">
            <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Paid Tax Entry</h4>
        </div>
        <div class="card-panel">
            <!--<h4 class="header2">Search Invoice</h4>-->
            <div class="row">
                <div>
                    <div class="col s12 m12 l12">
                        <div class="col s12 m12 l12">
                            <div class="card-panel">
                                <h4 class="header2">Tax Details</h4>
                                <div class="row">
                                    <div class="row">
                                        <div class="input-field col s12 m6">
                                            <label for="paymentDate">Date</label>
                                            <input id="paymentDate" type="date" class="datepicker" data-validation="date" data-content="Please Select a Date">
                                        </div>
                                        <div class="input-field col s12 m6">
                                            <label for="taxDescription">Description</label>
                                            <input id="taxDescription" type="text">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12 m3">
                                            <label for="cgstTax">CGST</label>
                                            <input id="cgstTax" autocomplete="off" onchange="calculateTotalTax();" type="text">
                                        </div>
                                        <div class="input-field col s12 m3">
                                            <label for="sgstTax">SGST</label>
                                            <input id="sgstTax" autocomplete="off" onchange="calculateTotalTax();" type="text">
                                        </div>
                                        <div class="input-field col s12 m3">
                                            <label for="igstTax">IGST</label>
                                            <input id="igstTax" autocomplete="off" onchange="calculateTotalTax();" type="text">
                                        </div>
                                        <div class="input-field col s12 m3">
                                            <label for="paymentPaidAmount" class="active">Tax Total</label>
                                            <input id="paymentPaidAmount" readonly type="text">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col s12">
                                            <label for="paymentMode">Select Mode</label>
                                            <div class="sel-wrap">
                                                <select id="paymentMode" class="floating-label active" onchange="loadTaxModeDetails(this.value)" data-validation="select" data-content="Please Select Mode">
                                                    <option value="" selected disabled >Please Select</option>
                                                    <!--<option value="1">Cash</option>-->
                                                    <option value="2">Online</option>
                                                    <option value="3">Cheque</option>
                                                    <option value="4">Demand Draft</option>
                                                </select>
                                                <div class='bar'></div>
                                            </div>
                                            <script>
                                                floatingSelect2('paymentMode');
                                            </script>
                                        </div>
                                        <div id="bankDetails" class="input-field col s12">

                                        </div>
                                        <div class="input-field col s12 m12">
                                            <center><button  class="btn teal darken-2" form="paidTaxEntry">Save</button></center>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<?php self::loadDesign('popup/generalpopup'); ?>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/hsn/addHsn.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/transaction/transaction.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">


<script type="text/javascript" src="<?php echo URL; ?>assets/js/transaction/transaction.js"></script>
<?php
$paidTaxResult = accountBlock::getPaidTaxDetails();
?>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Paid Tax Report</h4>
    </div>
    <div class="card-panel">
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table id="data-table-simple" class="responsive-table display">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Date</th>
                                <th>Description</th>
                                <th>SGST</th>
                                <th>CGST</th>
                                <th>IGST</th>
                                <th>Total Tax</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($paidTaxResult as $paidTax) {
                                $paidTax = (array) $paidTax;
                                ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo date('d-m-Y', (strtotime($paidTax[tax_entry_date]))); ?></td>
                                    <td><?php echo $paidTax[tax_entry_check_dd_number]; ?></td>
                                    <td><?php echo $paidTax[tax_entry_sgst]; ?></td>
                                    <td><?php echo $paidTax[tax_entry_cgst]; ?></td>
                                    <td><?php echo $paidTax[tax_entry_igst]; ?></td>
                                    <td><?php echo $paidTax[tax_entry_totalTax]; ?></td>
                                    <td><i onclick="deletePaidTax(<?php echo $paidTax[tax_entry_id] ?>);" class="mdi-action-delete" style="color:red;cursor:pointer;"></i></td>
                                </tr>
                                <?php
                                $count++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php self::loadDesign('popup/paidtaxdeletepopup'); ?>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">