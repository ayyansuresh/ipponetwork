<script type="text/javascript" src="<?php echo URL; ?>assets/js/payroll/easwari/payroll.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        
        $("#payrollEntry").materialvalidation({
            theme: "materialize"
        });
        $("#payrollEntry").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#payrollEntry").data().materialvalidation.methods.validate()) {
                savepayrollEntry();
            }
            return false;
        });
    });
</script>
<script>
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
</script>
<style>
    .picker__month-display{font-size: 1rem !important;}.picker__day-display{font-size: 2.5rem !important;}.picker__year-display{font-size: 1.5rem !important;}select.browser-default{margin-left: 1rem;}#makeInvoice:focus{background-color:#ff4081 !important;}#addNewProduct:focus{background-color:#ff4081 !important;}
    #paymentPaidAmount { display: none; }
</style>

<form id="payrollEntry" novalidate>
    <div class="container teal lighten-2">
        <div class="collection">
            <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Payroll Entry</h4>
        </div>
        <div class="col s12 m12 l12">
  <div class="card-panel">
      
    <br/>
    <div class="row">

      <!-- Payroll Date -->
      <div class="input-field col s12 m2">
        <i class="mdi-action-event prefix"></i>
        <input id="payrolldate" type="date" class="datepicker"
               data-validation="date" data-content="Date cannot be empty"
               value="<?php echo date('Y-m-d'); ?>">
        <label for="payrolldate" class="active">Payroll Date</label>
      </div>

        <!-- Customer Name -->
        <div class="input-field col s12 m4">
            <div class="input-group" >
                <label for="customerName"  class="active">Customer Name</label>
                <div class="sel-wrap">
                    <select id="customerName" class="floating-label active" data-validation="select" data-content="Please select Customer">
                        <?php echo journalBlock::getCustomerNameWithCityJournal(0); ?>
                    </select>
                    <div class='bar'></div>
                </div>  
            </div>
            <script>
                floatingSelect2('customerName');
            </script>
        </div>
        
        <!-- Staff Name -->
        <div class="input-field col s12 m4">
            <div class="input-group" >
                <label for="staffName"  class="active">Staff Name</label>
                <div class="sel-wrap">
                    <select id="staffName" class="floating-label active" data-validation="select" 
                            data-content="Please select staff">
                        <?php echo journalBlock::getallstaffName(0); ?>
                    </select>
                    <div class='bar'></div>
                </div>  
            </div>
            <script>
                floatingSelect2('staffName');
            </script>
        </div>
        
        <!-- Payroll amount -->
        <div class="input-field col s2">
        <input id="payrollamount" name="payrollamount" type="text" value="0"
               style="width:100%; font-size: 45px; color: red; font-weight: bold;">
        <label for="payrollamount" class="active" style="font-size: 20px; color: blue;">
          Total: Rs.
        </label>
      </div>
         
    </div>

    <!-- Payment Section -->
    <div class="row">

      <!-- Payment Mode -->
      <div class="input-field col s12 m4">
        <div class="sel-wrap">
           <label for="paymentMode" class="active">Select Payment Mode</label>
          <select id="paymentMode" class="floating-label active"
                  data-validation="select" 
                            data-content="Please select payment mode"
                  onchange="loadChangeModeDetails(this.value)">
            <option value="" selected >Please Select</option>
            <option value="1">Cash</option>
            <option value="2">Online</option>
            <option value="3">Cheque</option>
            <option value="4">Demand Draft</option>
          </select>
          <div class='bar'></div>
        </div>
        <script>floatingSelect2('paymentMode');</script>
      </div>

      <!-- Bank Name & Account Type -->
      <div class="input-field col s12 m4">
        <div id="bankdetails" style="display: none;">
          <label for="paymentBank" class="active">Bank Name & Account Type</label>
          <div class="sel-wrap">
            <select id="paymentBank" class="floating-label active">
              <option value="" selected>Select Bank</option>
              <?php echo accountBlock::getAccountNameByCompany(""); ?>
            </select>
            <div class='bar'></div>
          </div>
          <script>floatingSelect2('paymentBank');</script>
        </div>
      </div>

      <!-- NEFT / IMPS / Cheque No / DD -->
      <div class="input-field col s12 m4">
        <div id="bankdetailsviapayment" style="display: none;">
          <input id="paymentviamode" name="paymentviamode" type="text"
                 style="height: 45px; font-size: 18px;">
          <label for="paymentviamode" class="active">NEFT / IMPS / Cheque No / DD</label>
        </div>
      </div>

    </div>
    
     <!-- Description -->
     <div class="row">
      <div class="input-field col s12 m12">
        <input id="payrolldescription" name="payrolldescription" type="text"
               style="height: 45px; font-size: 18px;">
        <label for="payrolldescription" class="active">Description</label>
      </div>
     </div>

  </div>
</div>

        <table  style="margin-top:15px; ">
            <tr style="height:10px;background-color: #00796b;color:white;border-color: black;border: 1px solid;">
                <th style="width:30%;">
                    Designation
                </th>
                <th style="width:15%;">
                    Per Day Salary
                </th> 
                <th style="width:15%;">
                    Quantity 
                </th> 
                <th style="width:15%;">
                    TOTAL
                </th>
                <th style="width:30%;">
                    Description
                </th> 
                <th style="width:10%;">
                    Action
                </th>
            </tr>
        </table>
        <div style="height:400px;  overflow-x: auto; width: 100%;">
            
            <script> loadDesignationDetail();</script>
            <table style="background-color: white" id="myTable" style="margin-top:15px; ">
                <tr id="barcoderow0" class="normalhighlight" style="height:20px;border: 0px solid">
                    
                    <td class="input-field" id="loadvendor" style="width:30%;">
                               <div style="height: 25px;" class="sel-wrap">
                            <select style="height: 25px; width:10% !important; " 
                                    id="linedesignationid0" data-validation="select" data-content="Please Select Staff" 
                                    name="linedesignationid[]" class="floating-label active" onchange="getandsetdesignationid(0)"
                                    data-validation="select" data-content="Please Select Designation Name">
                                <option value="0" selected disabled>Select an Designation</option>
                              
                            </select>
                                   
                             <input  style="height: 25px;font-size:18px;" id="linedesignationidvalue0" 
                                type="hidden" value="0"  name="linedesignationidvalue[]" onkeyup="" >
                             
                             <script> appendDesignationList('linedesignationid0');
                             floatingSelect2('linedesignationid0');</script>
                            <div class='bar'></div>
                        </div>  
<!--                      <script>
                            //floatingSelect2lineDesignationdropdown('linedesignationid0');
                            //floatingSelect2('linedesignationid0');

                         

                        </script>-->
           

                    </td>  
                    
                    <td class="input-field" style="width:15%;">
                        <input  style="height: 25px;font-size:18px;" id="lineperdaysalary0" 
                                type="text" value="0"  name="lineperdaysalary[]" onchange="updateTotalAmount()" >
                        <label  for="lineperdaysalary0" class="active"> Per Day Salary </label>
                    </td>
                    
                    <td class="input-field" style="width:15%;">
                        <input  style="height: 25px;font-size:18px;" id="linedaysqty0" 
                                type="text" value="0"  name="linedaysqty[]" onchange="updateTotalAmount()" >
                        <label for="linedaysqty0" class="active">Days</label>
                    </td>
                    
                    <td class="input-field" style="width:15%;">
                        <input  style="height: 25px;font-size:18px;" id="linetotal0" 
                                type="text" value="0"  onchange="updateTotalAmount()"  name="linetotal[]" >
                        <label  for="linetotal0" class="active">Line Total</label>
                    </td>
                   
                     <td class="input-field" style="width:30%;">
                        <input  style="height: 25px;font-size:18px;" id="linedescription0" 
                            placeholder="please enter description"    type="text" name="linedescription[]" >
                        <label  for="linedescription0" class="active">Line Description</label>
                    </td>
                    
                    <td class="input-field" style="width:10%;">
                        <button type="button" class="btn red" style="height:25px; line-height:25px; padding:0 10px;" 
                                onclick="deleteRow(0)">Delete</button>
                    </td>

                </tr>
               
            </table>
        </div>
         <div class="input-field col s12" value="0.00">
            <center>  <button id="makeInvoice" class="btn waves-light red " type="submit">
                    MAKE PAYROLL</button> </center>
        </div>

</form>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
