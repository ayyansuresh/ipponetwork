<div class="col s12">
    <div class="input-group">
        <label for="bankName">Bank Name</label>
        <div class="sel-wrap">
            <select id="bankName" class="floating-label active">
                <option value="" selected disabled >Please Select</option>
                <option value="1" >HDFC</option>
                <option value="2" >AXIS</option>
                <option value="3" >ICICI</option>
                <option value="4" >SBI</option>
            </select>
            <div class='bar'></div>
        </div>  
    </div>
    <script>
        floatingSelect2('bankName');
    </script>
</div>
<div class="input-field col s12 m6">
    <label for="ddNumber">DD Number</label>
    <input id="ddNumber" type="text">
</div>
<div class="input-field col s12 m6">
    <label for="advanceAmount">Advance Amount</label>
    <input id="advanceAmount" type="text">
</div>