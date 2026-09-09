<div class="modal-content">
    <div class="row">
        <div class="col s12 m12 l12">
            <div class="card-panel">
                <h4 class="header2">SUCCESS (BILL NUMBER -
                    <?php echo $salesBillNumber="<script>var billnumber=$('#billNumber').val() ;$('#billnumberfinal').val(billnumber)</script>";
                    $link=URL."sales-sales/generateInvoicePdf?company=".generalhelper::getSessionElement('beebooklogincompanyid')
        ."&accountYear=".generalhelper::getSessionElement('beebookloginaccountyearid')
        ."&frombillnumber=".$salesBillNumber.
        "&tobillnumber=".$salesBillNumber."&gstType=3&billType=1";

                    ?>
                    )
                    <input id="billnumberfinal" readonly></span>
                    <!--<a href="<?php //echo $link?>" id="Print" target="_blank">Print</a> -->
                </h4>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer green lighten-4">
    <button  class="waves-effect waves-red btn-flat modal-action" onclick="closeSalesFinanceModal(<?php echo generalhelper::getGetElement('billGSTType') ?>);">Close</button>
</div>