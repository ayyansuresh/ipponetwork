<div class="col s12">
    <div class="input-group">
        <label for="paymentMode">Payment Mode</label>
        <div class="sel-wrap">
            <select id="paymentMode" class="floating-label active" onchange="loadBankDetails(this.value)">
                <option value="" selected disabled >Please Select</option>
                <option value="1" >Cash</option>
                <option value="2" >Online</option>
                <option value="3" >Cheque</option>
                <option value="4" >Demand Draft</option>
            </select>
            <div class='bar'></div>
        </div>  
    </div>
    <script>
        floatingSelect2('paymentMode');
    </script>
</div>