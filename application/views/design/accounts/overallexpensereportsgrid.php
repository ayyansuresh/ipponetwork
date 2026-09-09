<script type="text/javascript" src="<?php echo URL; ?>assets/js/reports/reports.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<?php
$companyID = generalhelper::getSessionElement('beebooklogincompanyid');
$accountYear = generalhelper::getSessionElement('beebookloginaccountyearid');

$fromDate = generalhelper::getGetElement('fromDate');
$toDate  =  generalhelper::getGetElement('toDate');

$result = accountBlock::getAllExpenseDetails($companyID, $accountYear,$fromDate,$toDate);
//var_dump($result);
//$tot = 0;
//foreach ($result as $res) {
//    
//    $tot=$tot+$res['amount'];
//}
?>

<script>
$(document).ready(function () {
    $('.table').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        info: true
    });
});
</script>
<?php


?>

<div class="input-field col s12 m3" style="margin-left: 3%;">
    <button class="waves-effect waves-light btn teal darken-2" onclick="printOverallExpenseReports('<?php echo $fromDate; ?>','<?php echo $toDate; ?>')">
           <i class="mdi-av-my-library-books left"></i> Export to PDF</button>    
    <button class="waves-effect waves-light btn teal darken-2" onclick="sendGmail('<?php echo $fromDate; ?>','<?php echo $toDate; ?>')">
           <i class="mdi-communication-email left"></i>SEND MAIL</button>
<!--    <button class="waves-effect waves-light btn teal darken-2" onclick="loadWhatsappDetails();">
           <i class="mdi-communication-chat left"></i>SEND TO WHATSAPP</button>-->
</div>
<div id="loadMsg">
    
</div>
<div class="container teal lighten-2">   
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Overall Expense Report</h4>
    </div>
    <div class="card-panel">
        <div class="row">
            <div class="input-field col s12 m2">
                <i class="mdi-action-event prefix"></i>
                <input id="from" type="text" readonly value="<?php echo $fromDate;?>">
                <label for="from" class="active" >From Date</label>
            </div>
            <div class="input-field col s12 m2">
                <i class="mdi-action-event prefix"></i>
                <input id="to" type="text" readonly value="<?php echo $toDate; ?>">

                <label class="active" for="to">To Date</label>
            </div>
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table class="responsive-table display table">
                        <thead>
                            <tr>
                                <th style="text-align: center">S.No</th>
                                <th style="text-align: center">Date</th>
                                <th style="text-align: center">Customer Name(Site Name)</th>
                                <!--<th style="text-align: center">Payment Mode</th>-->
                                <th style="text-align: center">Payment Details</th>
                                <th style="text-align: center">Particulars</th>
                                <th style="text-align: center">Mobile</th>
                                <th style="text-align: right">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            $total = 0;
                            foreach ($result as $res) {
                                $payment=$res['bank'];
                                if($res['pm']!="Cash")
                                {
                                    $payment.=" (Payment made by ".$res['pm'].")";
                                    
                                }
                                
                                //(($res[customer_name] === null) || ($res[customer_name] === '')) ? $customerName = '' : $customerName = $res[customer_name]."(".$res[customer_site_name].") ";
                                ?>
                                <tr>
                                    <td style="text-align: center"><?php echo $count; ?></td>
                                    <td style="text-align: center"><?php echo date('d-m-Y', (strtotime($res['date']))); ?></td>
                                    <td style="text-align: center"><?php echo $res['customer'];?></td>
                                    <!--<td style="text-align: center"><?php echo $res['pm'];?></td>-->
                                    <td style="text-align: center"><?php echo $payment;?></td>
                                    <td style="text-align: center"><?php echo $res['description'];?></td>
                                    <td style="text-align: center"><?php echo $res['mobile'];?></td>
                                    <td style="text-align: right"><?php echo generalhelper::formatInIndianStyle(sprintf('%.2f', $res['amount'])); ?></td>

                                </tr>
                                <?php
                                $total = $total + $res['amount'];
                                $count++;
                            }
                            ?>
                                                      
                        </tbody>
                        <tfoot>
                        <td colspan="5"></td>
                        <td><strong>Total Expenses</strong></td><td style="text-align: right"><strong><?php echo generalhelper::formatInIndianStyle($total); ?></strong></td>
                        </tfoot>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php //self::loadDesign('popup/easwari/addwhatsappdetailspopup');