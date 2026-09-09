<?php
//$gstType = $_GET['gstType'];
$companyId = $_SESSION['beebooklogincompanyid'];
$accountyear = $_SESSION['beebookloginaccountyearid'];
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
    <button  class="waves-effect waves-red btn-flat modal-action" onclick="closeSalesRetailModal(<?php echo generalhelper::getGetElement('billGSTType') ?>);">Close</button> 
    <button  class="waves-effect waves-red btn-flat" onclick="print('printpage', '<?php echo $companyId; ?>', '<?php echo $accountyear; ?>');">Print</button> 
</div>
<script>

    function print(printpage, company, accountYear)
    {
        var gstType = 3;
        var billType = 3;
        var billnumber = $('#billnumberfinal').val();
        completeurl = url + "sales-sales/retailPdf";
        var data = ' &company=' + company + '&accountYear=' + accountYear +
                '&frombillnumber=' + billnumber + '&tobillnumber=' + billnumber + '&gstType=' + gstType + '&billType=' + billType;
        var result = ajaxloadwithresponsesnonjson('get', completeurl, data);
        var win = window.open();
        win.document.write(result);
        win.window.print();
        setTimeout(function () {
            win.window.close();
        }, 10);

    }
</script>