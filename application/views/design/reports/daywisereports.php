<script type="text/javascript" src="<?php echo URL; ?>assets/js/reports/reports.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#dayWiseReportsForm").materialvalidation({
            theme: "materialize"
        });
        $("#dayWiseReportsForm").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#dayWiseReportsForm").data().materialvalidation.methods.validate()) {
                loadDayWiseReportsDetails();
            }
            return false;
        });
    });
</script>
<script>
    /*$('.datepicker').pickadate({
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
     });*/
    $("#fromDate").pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15,
        formatSubmit: 'yyyy/mm/dd',
        format: 'yyyy-mm-dd',
        onSet: function (ele) {
            var picker2 = $('#toDate').pickadate('picker');
            var alr = $('#fromDate').pickadate('picker').get('highlight', 'yyyy-mm-dd');
            if (ele.select) {
                picker2.set('min', alr);
                picker2.clear();
                this.close();
            }
        }

    });

    $('#toDate').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15,
        formatSubmit: 'yyyy/mm/dd',
        format: 'yyyy-mm-dd',
        onSet: function (ele) {
            if (ele.select) {
                this.close();
            }
        }
    });

</script>
<style>
    .picker__month-display{font-size: 1rem !important;}.picker__day-display{font-size: 2.5rem !important;}.picker__year-display{font-size: 1.5rem !important;}select.browser-default{margin-left: 1rem;}
</style>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Daywise Reports</h4>
    </div>
    <form class="formValidate" id="dayWiseReportsForm" novalidate>
        <div class="card-panel">
            <h4 class="header2">Daywise Reports</h4>
            <div class="row">
                <div class="row">
                    <div class="input-field col s12 m4">
                        <i class="mdi-action-event prefix"></i>
                        <input id="fromDate" type="date" class="datepicker" 
                                value="<?php echo generalhelper::getSessionElement('beebookloginaccountyearfromdate'); ?>"
                               data-validation="date" data-content="From Date cannot be empty">
                        <label class="active" for="fromDate">From Date</label>
                    </div>
                    <div class="input-field col s12 m4">
                        <i class="mdi-action-event prefix"></i>
                        <input id="toDate" type="date" class="datepicker"
                                 value="<?php echo generalhelper::getSessionElement('beebookloginaccountyeartodate'); ?>"
                               data-validation="date" data-content="To Date cannot be empty">
                        <label class="active" for="toDate">To Date</label>
                    </div>
                    <div class="input-field col s12 m4">
                        <button class="waves-effect waves-light btn teal darken-2" form="dayWiseReportsForm" type="submit" name="action"><i class="mdi-av-my-library-books left"></i> Go</button>
                        <!--<p><a class="waves-effect waves-light btn teal darken-2" href="#!" onclick="loadDayWiseReportsDetails();"><i class="mdi-av-my-library-books left"></i> Go</a></p>-->
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div id="loadDayWiseGrid"></div>