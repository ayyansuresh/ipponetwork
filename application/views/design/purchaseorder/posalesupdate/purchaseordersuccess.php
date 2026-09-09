<div class="modal-content">
    <div class="row">
        <div class="col s12 m12 l12">
            <div class="card-panel">
                <h4 class="header2"> PURCHASE ORDER SALES SUCCESS(BILL NUMBER -
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
    <button  class="waves-effect waves-red btn-flat modal-action" onclick="closePOSalesUpdateModal(<?php echo generalhelper::getGetElement('billGSTType') ?>);">Close</button>
</div>