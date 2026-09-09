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
<div class="input-field col s12 m6">
    <div class="input-group">
        <label for="paymentBank" class="active">Bank Name & Account Type</label>
        <div class="sel-wrap">
            <select id="paymentBank" class="floating-label active" data-validation="select" data-content="Please Select a Customer">
                <option value="" selected >Select Bank</option>
                <?php echo accountBlock::getAccountNameByCompany(""); ?>
            </select>
            <div class='bar'></div>
        </div>  
    </div>
    <script>
        floatingSelect2('paymentBank');
        // $("#customerName").val("1").trigger("change");
    </script>
</div>
<div class="input-field col s12 m6">
    <label for="ddNumber">DD Number</label>
    <input id="ddNumber" type="text">
</div>