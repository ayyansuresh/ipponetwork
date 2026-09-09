<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#LabourWagesUpdate").materialvalidation({
            theme: "materialize"
        });
        $("#LabourWagesUpdate").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#LabourWagesUpdate").data().materialvalidation.methods.validate()) {
                loadLabourWagesGrid();
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
<form id="LabourWagesUpdate" novalidate>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Labour Wages Update</h4>
    </div>
    <div class="card-panel">
        <h4 class="header2">Labour Wages Update</h4>
        <div class="row">
            <div class="row">
                        <div class="input-field col s12 m2">
                        <i class="mdi-action-event prefix"></i>
                        <input id="fromdate" type="date" class="datepicker" value="">
                        <label for="fromdate" class="active">From Date</label>
                    </div>
               <div class="input-field col s12 m2">
                        <i class="mdi-action-event prefix"></i>
                        <input id="todate" type="date" class="datepicker" 
                               
                               value="">
                        
                        <label for="todate" class="active">To Date</label>
                    </div>
                             
                 <div class="input-field col s12 m4">
                        <button class="btn teal darken-2" type="submit" form="LabourWagesUpdate">SEARCH</button>
                    </div>
            </div>
        </div>
    </div>
</div>
    </form>
<div id="loadLabourGrid">  </div>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/item/updateItem.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">
