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
        $("#customerTransaction").materialvalidation({
            theme: "materialize"
        });
        $("#customerTransaction").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#customerTransaction").data().materialvalidation.methods.validate()) {
                makeCustomerTDS();
            }
            return false;
        });
    });
</script>
<?php
$txnType = generalhelper::getGetElement('txnType');
if ($txnType == 1) {
    $display = "Credit";
} else {
    $display = "Debit";
}
?>
<form id="customerTransaction">
    <div class="container teal lighten-2">
        <input id="transactionType" type="hidden" value="<?php echo $txnType ?>">
        <div class="collection">
            <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">
                <?php 
                    if($txnType == "1") {
                        echo "Sales TDS";
                    } else {
                        echo "Purchase TDS"; 
                    }
                ?>
            </h4>
        </div>
        <div class="card-panel">
            <!--<h4 class="header2">Search Invoice</h4>-->
            <div class="row">
                <div class="col s12 m12 l12">
                    <div class="card-panel">
                        <h4 class="header2">TDS</h4>
                        <div class="row">
                            <div class="row">
                                <div class="input-field col s12 m6" id="normalCustomer" >
                                    <div class="input-group">
                                        <label for="customerName">Customer Name</label>
                                        <div class="sel-wrap">
                                            <select id="customerName" class="floating-label active" data-validation="select" data-content="Please Select a Customer">
                                                <option value="" selected disabled>Select Customer</option>
                                                <?php echo transactionsBlock::getCustomerName(); ?>
                                            </select>
                                            <div class='bar'></div>
                                        </div>
                                    </div>
                                    <script>
                                        floatingSelect2('customerName');
                                        // $("#customerName").val("1").trigger("change");
                                    </script>
                                </div>
                                <div class="input-field col s12 m6">
                                    <div class="input-group">
                                        <label for="paymentDate">Date</label>
                                        <input id="paymentDate" type="date" class="datepicker">
                                    </div>
                                </div>
                            </div>
                            <!--<div class="input-field col s12 m4">
                                <div class="input-group">
                                    <label for="transactionType">Transaction Type</label>
                                    <div class="sel-wrap">
                                        <select id="transactionType" class="floating-label active" data-validation="select" data-content="Please Select a Liability">
                                            <option value="" selected >Select Transaction Type</option>
                                            <option value="1" >Credit</option>
                                            <option value="2" >Debit</option>
                                        </select>
                                        <div class='bar'></div>
                                    </div>  
                                </div>
                                <script>
                                    floatingSelect2('transactionType');
                                    // $("#customerName").val("1").trigger("change");
                                </script>
                            </div>-->
                            <div class="row">
                                <div class="input-field col s12 m6">
                                    <label for="paymentPaidAmount">Amount</label>
                                    <input id="paymentPaidAmount" type="text">
                                </div>
                                <div class="input-field col s12 m6" id="loadSubCategory">
                                    <label for="txnDescription">Description</label>
                                    <input id="txnDescription" type="text">
                                </div>
                                <!--<div class="col s12">
                                    <div class="input-group">
                                        <label for="paymentMode">Select Mode</label>
                                        <div class="sel-wrap">
                                            <select id="paymentMode" class="floating-label active" onchange="loadModeDetails(this.value)">
                                                <option value="" selected disabled >Please Select</option>
                                                <option value="1">Cash</option>
                                                <option value="2">Online</option>
                                                <option value="3">Cheque</option>
                                                <option value="4">Demand Draft</option>
                                            </select>
                                            <div class='bar'></div>
                                        </div>  
                                    </div>
                                    <script>
                                        floatingSelect2('paymentMode');
                                    </script>
                                </div>
                                <div id="bankDetails" class="input-field col s12">

                                </div>-->
                                <div class="input-field col s12 m12">
                                    <center><button  class="btn teal darken-2" form="customerTransaction">Save</button></center>
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
<?php
$creditNoteResult = transactionsBlock::getTDS($txnType);
if ($txnType == 1) {
    $display = "Credit";
} else {
    $display = "Debit";
}
?>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;"> Customer TDS Reports</h4>
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
                                <th>Customer Name</th>
                                <th>Description</th>
                                <th>Amount</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($creditNoteResult as $creditNote) {
                                $creditNote = (array) $creditNote;
                                ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo date('d-m-Y', (strtotime($creditNote[customer_credit_debit_transaction_date]))); ?></td>
                                    <td><?php echo $creditNote[customer_name]; ?></td>
                                    <td><?php echo $creditNote[customer_credit_debit_transaction_description]; ?></td>
                                    <td><?php echo $creditNote[customer_credit_debit_transaction_amount]; ?></td>
                                    <td><i onclick="deleteCrdeitDebitNote(
                                    <?php echo $creditNote[customer_credit_debit_transaction_Id] ?>
                                    ,<?php echo $txnType;  ?>  
                                    );" class="mdi-action-delete" style="color:red;cursor:pointer;"></i></td>
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
<?php self::loadDesign('popup/tdsdelete'); ?>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">