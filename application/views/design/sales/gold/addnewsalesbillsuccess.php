<?php
$company = $_SESSION['beebooklogincompanyid'];
$accountyear = $_SESSION['beebookloginaccountyearid'];
$billType = 1;
?>
<div class="modal-content">
    <div class="row">
        <div class="col s12 m12 l12">
            <div class="card-panel">
                <h4 class="header2">SUCCESS (BILL NUMBER -
                    <?php echo $salesBillNumber = "<script>var billnumber=$('#billNumber').val() ;$('#billnumberfinal').val(billnumber)</script>";
                    ?>
                    )
                    <input id="billnumberfinal" readonly></span>
                </h4>
            </div>
        </div>

       




    </div>
</div>

<div class="modal-footer green lighten-4">
    <button  class="waves-effect waves-red btn-flat modal-action" onclick="print('printpage','<?php echo generalhelper::getGetElement('billGSTType') ?>','<?php echo $billType; ?>');">Print</button>
    <button  class="waves-effect waves-red btn-flat modal-action" onclick="closeSalesModal(<?php echo generalhelper::getGetElement('billGSTType') ?>);">Close</button>
</div>
<script>

    function print(printpage,gstType, billType)
    {
        var billType = 1;
        var billnumber = $('#billnumberfinal').val();
        var completeurl = url + 'sales-salesmalleswara/generateInvoicePdf?frombillnumber=' + billnumber +
            '&tobillnumber=' + billnumber + '&gstType=' + gstType + '&billType=' + billType;
        window.open(completeurl);
    }
</script>