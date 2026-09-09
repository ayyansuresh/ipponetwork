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
    <button  class="waves-effect waves-red btn-flat" onclick="printNewPage('printpage', '<?php echo $companyId; ?>', '<?php echo $accountyear; ?>');">Print</button> 
</div>

<script>

    function printNewPage(printpage, company, accountYear)
    {
        var gstType = 3;
        var billType = $("#billType").val();
        var completeurl = url + "sales-salesmalleswara/retailPdf";
        var billNumber = $("#billNumberDisplay").val();
        var data = ' &company=' + company + '&accountYear=' + accountYear +
                '&frombillnumber=' + billNumber + '&tobillnumber=' + billNumber + '&gstType=' + gstType + '&billType=' + billType + '&printpage=' + printpage;

        var result = ajaxloadwithresponsesnonjson('get', completeurl, data);
        // var result = ajaxloadwithresponsesnonjson('get',url,data);

        var win = window.open();
        win.document.write(result);
        win.window.print();
        // setTimeout(function(){ win.window.close(); },10);
        setTimeout(function () {
            win.window.close();
        }, 20);

        billGSTType = $("#billGSTType").val();
        closeSalesRetailModal(billGSTType);

    }
</script>
<script>
    printNewPage('printpage', '<?php echo $companyId; ?>', '<?php echo $accountyear; ?>');
</script>