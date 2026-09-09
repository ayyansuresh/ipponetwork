
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
    <button  class="waves-effect waves-red btn-flat" onclick="print('printpage');">Print</button>
</div>
<script>
    function printdiv(printpage)
    {
       
        var url = "http://127.0.0.1/oms/sales-sales/retailPdf";
        var data = "company=1&accountYear=1&frombillnumber=54&tobillnumber=54&gstType=3&billType=3";
        var result = ajaxloadwithresponsesnonjson('get',url,data);
        document.body.innerHTML = result;
        window.print();
        setTimeout(function(){ window.close(); },1);
    }
    
    function print(printpage)
    {    
       
         var url = "http://127.0.0.1/oms/sales-sales/retailPdf";
        var data = "company=1&accountYear=1&frombillnumber=54&tobillnumber=54&gstType=3&billType=3";
        var result = ajaxloadwithresponsesnonjson('get',url,data);
        
        var win = window.open();
        win.document.write(result);
        win.window.print();
        setTimeout(function(){ win.window.close(); },10);
      
    }
</script>