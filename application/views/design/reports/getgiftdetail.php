<!--<script type="text/javascript" src="<?php echo URL; ?>assets/js/sales/newSalesTaxInclude.js"></script>-->
<script type="text/javascript" src="<?php echo URL; ?>assets/js/sales/thangam/newSalesTaxInclude.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize-validation.min.js"></script>
<script>
    loadInitialItemDetail();
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#salesInvoice").materialvalidation({
            theme: "materialize"
        });
        $("#salesInvoice").submit(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            if ($("#salesInvoice").data().materialvalidation.methods.validate()) {
                //   makeRetailSalesInvoice();
            }
            return false;
        });
        //  $('label[for="productId0"]').addClass('filled active');
        //  $('#productId0').focus();
        $('label[for="barcodeId0"]').addClass('filled active');
        $('#barcodeId0').focus();
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
    #myTable td input{margin-bottom:0px !important;}
</style>
<?php
$partyType = 2;
//$gstType = $_GET['gstType'];
$companyId = $_SESSION['beebooklogincompanyid'];
$accountyear = $_SESSION['beebookloginaccountyearid'];
$totalpoint = generalhelper::getGetElement('totalpoint'); //Within State
$customerId = generalhelper::getGetElement('customerId'); //Within State
$totalproduct = (int) ($totalpoint / 50);
?>

<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Gift Detail</h4>
    </div>
    <div class="col s12 m12 l12">

        <div class="row">
            <div class="col s12 m12 l12">
                <div class="card-panel divHeight">
                    <table id="myTable" style="margin-top:15px;">
                        <tr>
                            <td>
                                <label for="giftproduct" class="active">PRODUCT</label>
                                <input id="giftproduct" type="text"
                                       value="1/2 LITRE GROUNDNUT OIL">
                            </td>
                            <td>
                                <label for="giftquantity" class="active">QUANTITY</label>
                                <input id="giftquantity" type="text"
                                       value="<?php echo $totalproduct ?>">
                                <input id="totalgift" type="hidden"
                                       value="<?php echo $totalproduct ?>">
                            </td>
                        </tr>
                    </table>
                    <div class="input-field col s12 m12">

                        <center> <button class="btn teal darken-2" type="submit" onclick="makeGiftDetail('<?php echo $customerId; ?>');">DELIVER GIFT</button> </center>  
                    </div>
                </div>
            </div>  
            <!-- Form with validation -->

        </div>
    </div>
</div>
<div id="giftdetails">
</div>
<!--plugins.js - Some Specific JS codes for Plugin Settings-->
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">

