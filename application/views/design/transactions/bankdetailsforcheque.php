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
    <label for="paymentDate">Payment Date</label>
    <input id="paymentDate" type="date" class="datepicker">
</div>
<div class="input-field col s12 m6">
    <label for="paymentDescription">Cheque Number</label>
    <input id="paymentDescription" type="text">
</div>
<div class="input-field col s12 m6">
    <label for="paymentPaidAmount">Amount</label>
    <input id="paymentPaidAmount" type="text">
</div>
<div class="input-field col s12 m6">
    <label for="description">Description</label>
    <input id="description" type="text">
</div>