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
                updatepayrollEntry();
            }
            return false;
        });
    });
</script>
<script>
    $('.datepicker').pickadate({
        selectMonths: true,
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
<?php
    $getPayroll = salesInvoiceBlock::getpayrollDataById();
    $getPayroll = (array) $getPayroll[0];
    $getpayrollitem = salesInvoiceBlock::getPayrollItemDataById();
?>
<form id="payrollEntry" novalidate>
    <div class="container teal lighten-2">
        <div class="collection">
            <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Payroll Update</h4>
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
               value="<?php echo $getPayroll[payroll_date]; ?>">
        <label for="payrolldate" class="active">Payroll Date</label>
      </div>

      <div class="input-field col s12 m1">
        <input id="payrollvoucher" name="payrollvoucher" type="text"
               value="<?php echo $getPayroll[expenses_voucher_number]; ?>"
               style="height: 45px; font-size: 18px;">
        <label for="payrollvoucher" class="active">Voucher No</label>
      </div>
      
      <!-- Customer Name -->
      <div class="input-field col s12 m4" id="normalCustomer">
        <label for="customerName" class="active">Customer Name</label>
        <div class="sel-wrap" style="height: 25px;">
          <select style="height:25px" id="customerName" class="floating-label active">
            <?php echo journalBlock::getCustomerNameWithCityJournal($getPayroll[payroll_customer_id]); ?>
          </select>
          <div class='bar'></div>
        </div>
        <script>floatingSelect2('customerName');</script>
      </div>
      
      <!-- Staff Name -->
      <div class="input-field col s12 m3" id="normalCustomer">
        <label for="staffName" class="active">Staff Name</label>
        <div class="sel-wrap" style="height: 25px;">
          <select style="height:25px" id="staffName" class="floating-label active">
            <?php echo journalBlock::getallstaffName($getPayroll[payroll_staff_id]); ?>
          </select>
          <div class='bar'></div>
        </div>
        <script>floatingSelect2('staffName');</script>
      </div>
      
      <!--Payroll Total Amount-->
      <div class="input-field col s12 m2">
        <input id="payrollamount" name="payrollamount" type="text" 
                value="<?php echo $getPayroll[payroll_amount]; ?>"
               style="width:100%; font-size: 45px; color: red; font-weight: bold;">
        <label for="payrollamount" class="active" style="font-size: 20px; color: blue;">
          Total: Rs.
        </label>
      </div>

    </div>

      <!-- Description -->
      <div class="input-field col s12 m6">
        <input id="payrolldescription" name="payrolldescription" type="text"
               value="<?php echo $getPayroll[payroll_description]; ?>"
               style="height: 45px; font-size: 18px;">
        <input id="payrollid" type="hidden" value="<?php echo $getPayroll[payroll_id]; ?>" >
        <input id="expenseid" type="hidden" value="<?php echo $getPayroll[expenses_expenses_id]; ?>" >
        <label for="payrolldescription" class="active">Description</label>
      </div>
      
      
    <!-- Payment Section -->
    <div class="row">

      <!-- Payment Mode -->
      <div class="input-field col s12 m4">
        <label for="paymentMode">Select Payment Mode</label>
        <div class="sel-wrap">
          <select id="paymentMode" class="floating-label active" onchange="loadChangeModeDetails(this.value)">
            <option value="" selected disabled>Please Select</option>
            <option value="1"  <?php if ($getPayroll[expenses_payment_mode] == 1) echo 'selected'; ?> >Cash</option>
            <option value="2"  <?php if ($getPayroll[expenses_payment_mode] == 2) echo 'selected'; ?> >Online</option>
            <option value="3"  <?php if ($getPayroll[expenses_payment_mode] == 3) echo 'selected'; ?> >Cheque</option>
            <option value="4"  <?php if ($getPayroll[expenses_payment_mode] == 4) echo 'selected'; ?> >Demand Draft</option>
          </select>
          <div class='bar'></div>
        </div>
        <script>floatingSelect2('paymentMode');</script>
      </div>
     
      <!-- Bank Name & Account Type -->
      <div class="input-field col s12 m4">
        <div id="bankdetails" 
             style="<?php if ($getPayroll[expenses_payment_mode] != 1) { echo "display:block"; } else
                 { echo "display:none"; } ?>">
          <label for="paymentBank" class="active">Bank Name & Account Type</label>
          <div class="sel-wrap">
            <select id="paymentBank" class="floating-label active"
                    data-validation="select" data-content="Please Select a Customer">
              <?php echo accountBlock::getAccountNameByCompany($getPayroll[expenses_account_ref_id]); ?>
            </select>
            <div class='bar'></div>
          </div>
          <script>floatingSelect2('paymentBank');</script>
        </div>
      </div>

      <!-- NEFT / IMPS / Cheque No / DD -->
      <div class="input-field col s12 m4">
        <div id="bankdetailsviapayment"
          style="<?php if ($getPayroll[expenses_payment_mode] != 1) { echo "display:block"; } else
                 { echo "display:none"; } ?>">
          <input id="paymentviamode" name="paymentviamode" type="text"
                 
                 style="height: 45px; font-size: 18px;">
          <label for="paymentviamode" class="active">NEFT / IMPS / Cheque No / DD</label>
        </div>
      </div>

    </div>

            <br/>
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
            <table style="background-color: white" id="myTable" style="margin-top:15px; ">
                <?php 
                for ($i = 0; $i < count($getpayrollitem); $i++) {
                    $item = (array) $getpayrollitem[$i];
                    if ($item[payroll_item_total] == 0) {
                        continue;
                    }
                ?>
                
                <tr id="barcoderow<?php echo $i; ?>" class="normalhighlight" style="height:20px;border: 0px solid">
                    
                    <td class="input-field" id="loadvendor" style="width:30%;">
                        <div style="height: 25px;" class="sel-wrap">
                            <select style="height: 25px; width:10% !important; " 
                                    id="linedesignationid<?php echo $i; ?>" data-validation="select" data-content="Please Select designation" 
                                    name="linedesignationid[]" class="floating-label active" onchange="getandsetdesignationid('<?php echo $i; ?>')"
                                    data-validation="select" data-content="Please Select designation">
                                <option value="<?php echo $item[payroll_item_designation_id]; ?> " > 
                                    <?php echo $item[designation_name]; ?>
                                </option>
                            </select>
                             <input  style="height: 25px;font-size:18px;" id="linedesignationidvalue<?php echo $i; ?>" 
                                type="hidden" value="<?php echo $item[payroll_item_designation_id]; ?>"  name="linedesignationidvalue[]">
                            <div class='bar'></div>
                        </div>  
                        <script>
                            floatingSelect2lineDesignationdropdown('linedesignationid<?php echo $i; ?>');
                        </script>
                    </td>  
                    
                    <td class="input-field" style="width:15%;">
                        <input  style="height: 25px;font-size:18px;" id="lineperdaysalary<?php echo $i; ?>" 
                            onchange="updateTotalAmount()" 
                            type="text" value="<?php echo $item[payroll_item_perdaysalary]; ?>"  name="lineperdaysalary[]"  >
                    </td>
                    
                    <td class="input-field" style="width:15%;">
                        <input  style="height: 25px;font-size:18px;" id="linedaysqty<?php echo $i; ?>" 
                            onchange="updateTotalAmount()" 
                            type="text" value="<?php echo $item[payroll_item_dayscount]; ?>"  name="linedaysqty[]"  >
                    </td>
                    
                    <td class="input-field" style="width:15%;">
                        <input  style="height: 25px;font-size:18px;" id="linetotal<?php echo $i; ?>" 
                            onchange="updateTotalAmount()" 
                            type="text" value="<?php echo $item[payroll_item_total]; ?>" name="linetotal[]"  >
                    </td>
                   
                     <td class="input-field" style="width:30%;">
                        <input  style="height: 25px;font-size:18px;" id="linedescription<?php echo $i; ?>" 
                                value="<?php echo $item[payroll_item_description]; ?>" 
                            placeholder="please enter description"    type="text" name="linedescription[]" >
                    </td>
                    
                    <td class="input-field" style="width:10%;">
                        <button type="button" class="btn red" style="height:25px; line-height:25px; padding:0 10px;" 
                                onclick="deleteRow(<?php echo $i; ?>)">Delete</button>
                    </td>
                    <script>  setrowcount('<?php echo $i; ?>') </script>
                </tr>
                
                <?php } ?>
            </table>
            <script>   
               
                addField(); 
                            </script>
        </div>
         <div class="input-field col s12" value="0.00">
            <center>  <button id="makeInvoice" class="btn waves-light red " type="submit">
                    Update PAYROLL</button> </center>
        </div>

</form>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
