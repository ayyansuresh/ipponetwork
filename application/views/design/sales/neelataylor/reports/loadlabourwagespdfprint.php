<?php
$company = generalhelper::getGetElement('company');
$accountyear = generalhelper::getGetElement('accountyear');
$fromDate = generalhelper::getGetElement('fromdate');
$toDate = generalhelper::getGetElement('todate');
$labourId = generalhelper::getGetElement('labourId');
$labourWagesDetails = salesInvoiceBlock::getLabourWagesGridDetails();
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
                                 <th style="border:1px solid #000;">Wages Date</th>
                                 <th style="border:1px solid #000;">Wages Number</th>
                                 <th style="border:1px solid #000;">Employee Name</th>
                                 <th style="border:1px solid #000;">Present/Absent</th>
                                 <th style="border:1px solid #000;">Amount</th>
                                </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($labourWagesDetails as $labourWages) {
                                $labourWages = (array) $labourWages;
                            ?>
                                    <tr>
                                        <td style="border:1px solid #000;text-align: center;"><?php echo $count ?></td>
                                        <td style="border:1px solid #000;text-align: center;"><?php echo $labourWages[wages_wagesDate] ?></td>
                                        <td style="border:1px solid #000;text-align: center;"><?php echo $labourWages[wages_Number] ?></td>
                                        <td style="border:1px solid #000;text-align: center;"><?php echo $labourWages[employeeMaster_Name]  ?></td>
                                        <?php 
                                     if($labourWages[labourwages_inOutFlag] == 1){
                                         $inOut = "Present";
                                     } 
                                     else {
                                         $inOut = "Absent";
                                     }
                                     ?>
                                        <td style="border:1px solid #000;text-align: center;"><?php echo $inOut; ?></td>
                                        <td style="border:1px solid #000;text-align: center;"><?php echo $labourWages['labourWagesAmount'] ?></td>
                                        

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
