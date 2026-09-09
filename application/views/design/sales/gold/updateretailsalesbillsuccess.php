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
    <button  class="waves-effect waves-red btn-flat modal-action" onclick="closeRetailSalesModal(<?php echo generalhelper::getGetElement('billGSTType') ?>);">Close</button>
    <button  class="waves-effect waves-red btn-flat" onclick="print('printpage','<?php echo $companyId; ?>','<?php echo $accountyear; ?>');">Print</button>
</div>
<script>
    function printdiv(printpage,gstType, company, accountYear)
    {
       
         var billType = 3;
        var url = "http://127.0.0.1/vasantham/sales-sales/retailPdf";
        var data = url + 'sales-sales/generateInvoicePdf?  &company=' + company + '&accountYear=' + accountYear +
            '&frombillnumber=' + frombillnumber + '&tobillnumber=' + tobillnumber + '&gstType=' + gstType + '&billType=' + billType;
        var result = ajaxloadwithresponsesnonjson('get',url,data);
        document.body.innerHTML = result;
        window.print();
        setTimeout(function(){ window.close(); },1);
    }
    
    function print(printpage,company, accountYear)
    {               
        var gstType = 3;
        var billType = 3;
        var billnumber=$('#billnumberfinal').val() ; 
        var url = "http://127.0.0.1/vasantham/sales-sales/retailPdf";
        var data =' &company=' + company + '&accountYear=' + accountYear +
            '&frombillnumber=' + billnumber + '&tobillnumber=' + billnumber   + '&gstType=' + gstType + '&billType=' + billType;
        var result = ajaxloadwithresponsesnonjson('get',url,data);
        
        var win = window.open();
        win.document.write(result);
        win.window.print();
        setTimeout(function(){ win.window.close(); },10);
      
    }
</script>











