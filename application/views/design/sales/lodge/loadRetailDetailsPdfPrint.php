<?php
$company = generalhelper::getGetElement('company');
$accountyear = generalhelper::getGetElement('accountyear');
$billNumber = generalhelper::getGetElement('billId');
$roomDetails = salesInvoiceBlock::getRetailGridDetails();
?>
<div class="container teal lighten-2">    
    <div class="card-panel">
        <div class="row">
            <div id="admin" class="col s12">
                <div class="card material-table">
                    <table style="font-family:arial;font-size:14px !important; width:100%; border:1px solid #000;border-collapse: collapse;" >
                        <thead>
                            <tr>
                                 <th style="border:1px solid #000;">S.No</th>
                                 <th style="border:1px solid #000;">Date</th>
                                 <th style="border:1px solid #000;">Room Name</th>
                                 <th style="border:1px solid #000;">Customer Name</th>
                                </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($roomDetails as $room) {
                                $room = (array) $room;
                            ?>
                                    <tr>
                                        <td style="border:1px solid #000;text-align: center;"><?php echo $count ?></td>
                                        <td style="border:1px solid #000;text-align: center;"><?php echo $room[salesbill_sales_bill_date] ?></td>
                                        <td style="border:1px solid #000;text-align: center;"><?php echo $room[roomrent_number] ?></td>
                                        <td style="border:1px solid #000;text-align: center;"><?php echo $room[customer_name]  ?></td>
                                                                                                              

                                    </tr>
                                    <?php
                                    $count++;
                                }
                            
                            ?>
                        </tbody>

                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
