<?php
$companyId = $_SESSION['beebooklogincompanyid'];
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
    <button  class="waves-effect waves-red btn-flat modal-action" onclick="print('printpage','<?php echo generalhelper::getGetElement('billGSTType') ?>','<?php echo $billType; ?>','<?php echo $companyId; ?>','<?php echo $accountyear; ?>');">Print</button>
    <button  class="waves-effect waves-red btn-flat modal-action" onclick="closeOrderModal(<?php echo generalhelper::getGetElement('billGSTType') ?>);">Close</button>
</div>
<script>

    function print(printpage,gstType, billType ,company,accountYear)
    {
        var billType = 1;
        var billNumber = $('#billnumberfinal').val();
        var completeurl = url + 'sales-salesmalleswara/generateEstimatePdf?frombillnumber=' + billnumber +
            '&tobillnumber=' + billnumber + '&gstType=' + gstType + '&billType=' + billType + '&company=' + company + '&accountYear=' + accountYear + '&printpage=' +printpage;
        var result = ajaxloadwithresponsesnonjson('get', completeurl, data);
        
        var win = window.open();
        win.document.write(result);
        win.window.print();
       // setTimeout(function(){ win.window.close(); },10);
      setTimeout(function(){ win.window.close();  },10);
        closeEstimateModal(gstType);
    }
    
    
</script>