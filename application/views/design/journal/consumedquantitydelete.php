<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins/data-tables/data-tables-script.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/materalize/plugins/data-tables/css/jquery.dataTables.min.css">
<?php
$companyID = generalhelper::getSessionElement('beebooklogincompanyid');
$accountYear = generalhelper::getSessionElement('beebookloginaccountyearid');
$journalDetails = journalBlock::getJournalDetails($companyID, $accountYear);
?>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/journal/journal.js"></script>
<script>
    /*$(document).ready(function () {
     var table = $('.paymentSales').DataTable();
     
     $(".paymentSales thead th").each(function (i) {
     var title = $('.paymentSales thead tr:eq(0) th').eq($(this).index()).text();
     var select = $('<input type="text" placeholder=" ' + title + '" />')
     .appendTo($(this).empty())
     .on('keyup change', function () {
     table.column(i)
     .search($(this).val())
     .draw();
     });
     
     
     });
     });*/
</script>
<style>
    td i{cursor:pointer;}
</style>
<div class="container teal lighten-2">
    <div class="collection">
        <h4 class="collection-item teal darken-2 center-align" style="color:#fff !important;">Consumed Quantity Delete Details</h4>
    </div>
    <div class="card-panel">
        <!--<h4 class="header2">Search Invoice</h4>-->
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table id="data-table-simple" class="paymentSales responsive-table display">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Delete</th>
                                <th>Consumed Date</th>
                                <th>Site Name</th>
                                <th>Description</th>
                                <th>Task</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php
                                $count = 1;
                                $serialCount=1;
                                $journalId = 0;
                                $total = 0;
                                foreach ($journalDetails as $journalDetailsResult) {
                                    $journalDetailsResult = (array) $journalDetailsResult;
                                    if ($journalId != $journalDetailsResult[journal_Id]) {
                                        if ($count != 1) {
                                                $serialCount++;
                                    
                                            ?>
                                        </tr>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                <td><?php echo $serialCount; ?></td>
                                <td><i onclick="deleteJournalEntry('<?php echo $journalDetailsResult[journal_Id]; ?>');" class="mdi-action-delete" style="color:red;cursor:pointer;"></i></td>

                                <td><?php echo date('d-m-Y', (strtotime($journalDetailsResult[journal_journalDate]))); ?></td>
                                <td><?php echo $journalDetailsResult[journal_journalEntryByName]; ?></td>
                                <td><?php echo $journalDetailsResult[journal_journalDescription]; ?></td>
                                <td>
                                    
                                    <?php
                                    if ($journalDetailsResult[journalItems_transactionType] == 2) {
                                        echo '<font color="red">Output : ' . $journalDetailsResult[items_name] ." (".$journalDetailsResult[journalItems_quantity]. ")</font><br/>";
                                    } else {
                                        echo '<font color="green">Output : ' . $journalDetailsResult[items_name] ." (".$journalDetailsResult[journalItems_quantity]. ")</font><br/>";
                                    }
                                } else {
                                    if ($journalDetailsResult[journalItems_transactionType] == 2) {
                                        echo '<font color="red">Output : ' . $journalDetailsResult[items_name] ." (".$journalDetailsResult[journalItems_quantity]. ")</font><br/>";
                                    } else {
                                        echo '<font color="green">Output : ' . $journalDetailsResult[items_name] ." (".$journalDetailsResult[journalItems_quantity]. ")</font><br/>";
                                    }
                                }
                                $journalId = $journalDetailsResult[journal_Id];
                                $count++;
                            }
                            ?>
                        </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php self::loadDesign('popup/consumedentrydelete'); ?>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/materialize/plugins.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/select2/custom.css">