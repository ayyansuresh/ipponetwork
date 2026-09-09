<?php

class gdcStockModel extends Controller {

    public static $gdcOutItemLastId = 0;
    public static $gdcInLastId = 0;
    public static $salesBillId = 0;
    public static $gdcOutItemCount = 0;

    function __construct($db) {
        try {
            self::$db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    public static function saveNewGdc() {
        $commit = 1;
        self::$db->beginTransaction();
        $commit = self::addNewGdc();
        if ($commit === 1) {
            $gdcOutId = self::$db->lastInsertId();
            $commit = self::saveGdcItems($gdcOutId);
        }
        if ($commit == 1) {
            $gdcOutItemLastId = self::$db->lastInsertId();
            self::$gdcOutItemLastId = $gdcOutItemLastId;
            $commit = self::saveStock();
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function addNewGdc() {
        $commit = 1;
        try {
?>
            <?php

            $sql = "insert into " . table_gdc_out . "(" . gdc_out_date
                    . "," . gdc_out_companyname
                    . "," . gdc_out_issuedperson
                    . "," . gdc_out_deliveryperson
                    . "," . gdc_out_contactnumber
                    . "," . gdc_out_status
                    . "," . gdc_out_createdtimetamp
                    . ")"
                    . " values (:" . gdc_out_date
                    . ",:" . gdc_out_companyname
                    . ",:" . gdc_out_issuedperson
                    . ",:" . gdc_out_deliveryperson
                    . ",:" . gdc_out_contactnumber
                    . ",:" . gdc_out_status
                    . ",NOW()"
                    . ")";
            $query = self::$db->prepare($sql);
            $parameter = array(
                ':' . gdc_out_date => generalhelper::getGetElement('gdcDate'),
                ':' . gdc_out_companyname => generalhelper::getGetElement('companyName'),
                ':' . gdc_out_issuedperson => generalhelper::getGetElement('issuedPerson'),
                ':' . gdc_out_deliveryperson => generalhelper::getGetElement('deliveryPerson'),
                ':' . gdc_out_contactnumber => generalhelper::getGetElement('contactNumber'),
                ':' . gdc_out_status => 0
            );
            $query->execute($parameter);
        } catch (PDOException $ex) {
            $commit = 0;
            echo $ex;
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex;
        }
        return $commit;
    }

    public static function saveGdcItems($gdcOutId) {
        $commit = 1;
        try {
            $lineproductId = generalhelper::getGetElementArray('lineproductId');
            self::$gdcOutItemCount = count($lineproductId);
            $uomId = generalhelper::getGetElementArray('uomId');
            $takenQuantity = generalhelper::getGetElementArray('takenQuantity');
            $itemDescription = generalhelper::getGetElementArray('description');
            $insert_values = array();
            $datafields = array(gdcoutItems_gdcOutRefId, gdcoutItems_itemId,
                gdcoutItems_uomId, gdcoutItems_takenQuantity,
                gdcoutItems_description,gdcoutItems_createdTimeStamp
            );
            for ($increment = 0; $increment < count($lineproductId); $increment++) {
                if ($lineproductId[$increment] != 0) {
                    $datafieldsValue = array(gdcoutItems_gdcOutRefId => $gdcOutId,
                        gdcoutItems_itemId => $lineproductId[$increment],
                        gdcoutItems_uomId => $uomId[$increment],
                        gdcoutItems_takenQuantity => $takenQuantity[$increment],
                        gdcoutItems_description => $itemDescription[$increment],
                        gdcoutItems_createdTimeStamp => date("Y-m-d H:i:s")
                    );
                    $insert_values = array_merge($insert_values, array_values($datafieldsValue));
                    $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($datafields)) . ')';
                }
            }
            $sql = "INSERT INTO " . table_gdc_outitems . "(" . implode(",", $datafields) . ") VALUES " . implode(',', $question_marks);
            $query = self::$db->prepare($sql);
            $query->execute($insert_values);
        } catch (PDOException $ex) {
            echo $ex;
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex;
        }
        return $commit;
    }
    
    public static function saveStock() {
        $commit = 1;
        try {
            $start = self::$gdcOutItemLastId;
            $end = $start + self::$gdcOutItemCount;
            $linequantity = generalhelper::getGetElementArray('takenQuantity');
            $linecommodityRefId = generalhelper::getGetElementArray('commodityId');
            $lineUOM = generalhelper::getGetElementArray('uomId');
            $lineUOMQuanity = generalhelper::getGetElementArray('uomQty');
            $linepackingfactor = generalhelper::getGetElementArray('packingFactor');
            $insert_values = array();
            $datafields = array(stock_UOM_id, stock_UOM_quantity,
                stock_account_year_ref_id, stock_commodity_ref_id,
                stock_company_ref_id, stock_created_by,
                stock_created_timestamp, stock_date,
                stock_table_reference_id, stock_table_reference_detail_id,
                stock_type
            );
            $arraycount = 0;
            for ($increment = $start; $increment < $end; $increment++) {
                if ($linecommodityRefId[$arraycount] != "") {
                    $lineUOMQuanity = $linequantity[$arraycount] * $linepackingfactor[$arraycount];
                    $updatStockSql = "update " . table_opening_stock . " set " . openingstock_trial_UOM_quantity
                            . " = " . openingstock_trial_UOM_quantity . " - " . $lineUOMQuanity
                            . " , " . openingstock_closing_UOMQuantity
                            . " = " . openingstock_closing_UOMQuantity . " - " . $lineUOMQuanity .
                            " where " . openingstock_commodity_ref_id . " = " . $linecommodityRefId[$arraycount] .
                            " and " . openingstock_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid')
                            . "  and " .
                            openingstock_account_year_ref_id . " =  " . generalhelper::getSessionElement('beebookloginaccountyearid');
                    $updatequery = self::$db->prepare($updatStockSql);
                    $updatequery->execute();


                    $datafieldsValue = array(stock_UOM_id => $lineUOM[$arraycount]
                        , stock_UOM_quantity => $lineUOMQuanity,
                        stock_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                        stock_commodity_ref_id => $linecommodityRefId[$arraycount],
                        stock_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                        stock_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                        stock_created_timestamp => date("Y-m-d H:i:s"),
                        stock_date => generalhelper::getGetElement('gdcDate'),
                        stock_table_reference_id => gdcoutitemsTable,
                        stock_table_reference_detail_id => $increment,
                        stock_type => debit
                    );
                    $insert_values = array_merge($insert_values, array_values($datafieldsValue));
                    $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($datafields)) . ')';
                }
                $arraycount++;
            }
           $sql = "INSERT INTO " . table_stock . "(" . implode(",", $datafields) . ") VALUES " . implode(',', $question_marks);
            $query = self::$db->prepare($sql);
            $query->execute($insert_values);
        } catch (PDOException $ex) {
            echo $ex;
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }

    public static function getGdcDetails() {
        $sql = "select a.*,b." . gdc_van_number . " from " . table_gdc . " as a INNER JOIN " . table_gdc_vannumber . " as b on a." . gdc_vanId . " = b." . gdc_van_id . " where " . gdc_status . " = 0";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getGdcDetailsById() {
        $gdcId = generalhelper::getGetElement('gdcId');
        $sql = "select a.*,b." . gdc_van_number . " from " . table_gdc . " as a INNER JOIN " . table_gdc_vannumber . " as b on a." . gdc_vanId . " = b." . gdc_van_id . " where a." . gdc_id . " = " . $gdcId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getGdcItem($gdcId) {
         $sql = "select a.*,b.*,c.*,d.* from " . table_gdc_outitems . " as a " .
                " inner join " . table_items . " as b on a." . gdcoutItems_itemId . " = b." .
                items_item_id .
                " inner join " . table_uom . " as c on a." . gdcoutItems_uomId . " = c." .
                uom_id .
                 " left join " . table_gdc_initems . " as d on a." . gdcoutItems_itemId . " = d." .
                gdcinItems_gdcOutItemRefId .
                " where a." . gdcoutItems_gdcOutRefId . " = " . $gdcId . " group by a." . gdcoutItems_id;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    
    public static function getGdcItemDetails() {
        $sql = "select a." . gdcItems_itemId . ",b." . items_name . " from " . table_gdc_items .
                " as a inner join " . table_items . " as b on b." . items_item_id . " = a." . gdcItems_itemId .
                " group by a." . gdcItems_itemId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getItemByCompanyName() {
        $sql = "select a." . gdcItems_id . ",b." . items_name . " from " . table_gdc_items .
                " as a inner join " . table_items . " as b on b." . items_item_id . " = a." . gdcItems_id .
                " group by a." . gdcItems_id;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getgdcReports() {

        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $van_id = generalhelper::getGetElement('vanId');
        $item_id = generalhelper::getGetElement('itemId');
        if ($item_id == "all") {
            $sql = "select a." . gdc_date . ",b." . gdcItems_takenQuantity . ",b." . gdcItems_salesQuantity . ",c." . items_name . " from " . table_gdc . " as a 
INNER JOIN " . table_gdc_items . " as b on a." . gdc_id . " = b." . gdcItems_gdcRefId . " 
INNER JOIN " . table_items . " as c on b." . gdcItems_itemId . " = c." . items_item_id . " 
where a." . gdc_vanNumber . " = '$van_number' 
and a." . gdc_date . " BETWEEN '$fromDate' and '$toDate'";
        } else {
            $sql = "select a." . gdc_date . ",a." . gdc_staffName . ",b." . gdcItems_takenQuantity . ",b." . gdcItems_returnQuantity . ",b." . gdcItems_salesQuantity . ",c." . items_name . " from " . table_gdc . " as a 
INNER JOIN " . table_gdc_items . " as b on a." . gdc_id . " = b." . gdcItems_gdcRefId . " 
INNER JOIN " . table_items . " as c on b." . gdcItems_itemId . " = c." . items_item_id . " 
    INNER JOIN " . table_gdc_vannumber . " as d on d." . gdc_van_id . " = $van_id
where a." . gdc_vanId . " = $van_id
and b." . gdcItems_itemId . " = $item_id  and a." . gdc_date . " BETWEEN '$fromDate' and '$toDate'";


            $query = self::$db->prepare($sql);
            $query->execute();

            return $query->fetchAll();
        }
    }
    public static function getGdcVanDetailsById($gdcId) {
        $sql = " select a." . gdc_van_number . " from " . table_gdc_vannumber . " as a where a." . gdc_van_id . "= $gdcId";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function getGdcItemDetailsById($itemId) {
        $sql = " select a." . items_name . " from " . table_items . " as a where a." . items_item_id . "= $itemId";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function getGdcStockDetails() {
        $sql = "select * from " . table_gdc_out . " where " . gdc_out_status . " = 0";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function getGdcStockDetailsById() {
        $gdcOutId = generalhelper::getGetElement('gdcOutId');
        $sql = "select * from " . table_gdc_out . " where " . gdc_out_id . " = " . $gdcOutId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function getGdcStockItem($gdcOutId) {
         $sql = "select a.*,b.*,c.* from " . table_gdc_outitems . " as a " .
                " inner join " . table_items . " as b on a." . gdcoutItems_itemId . " = b." .
                items_item_id .
                " inner join " . table_uom . " as c on a." . gdcoutItems_uomId . " = c." .
                uom_id .
                " where a." . gdcoutItems_gdcOutRefId . " = " . $gdcOutId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function updateGdcStockDetails() {
        $commit = 1;
        self::$db->beginTransaction();
        $commit = self::deleteGdcStock();
        if ($commit == 1) {
            $commit = self::addNewGdc();
        }
        if ($commit === 1) {
            $gdcId = self::$db->lastInsertId();
            $commit = self::saveGdcItems($gdcId);
        }
        if ($commit == 1) {
            $gdcOutItemLastId = self::$db->lastInsertId();
            self::$gdcOutItemLastId = $gdcOutItemLastId;
            $commit = self::saveStock();
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }
    public static function deleteGdcStock() {
        $gdcOutId = generalhelper::getGetElement('gdcOutId');
        $commit = 1;
        try {
            $gdcDeleteSql = "delete a.* from " . table_gdc_out . " as a "
                    . "where a." . gdc_out_id . "=" . $gdcOutId;

            $gdcDelete = self::$db->prepare($gdcDeleteSql);
            $gdcDelete->execute();

            $gdcItemDeleteSql = "delete  from " . table_gdc_outitems . " where " . gdcoutItems_gdcOutRefId . " = " . $gdcOutId;

            $gdcItemDelete = self::$db->prepare($gdcItemDeleteSql);
            $gdcItemDelete->execute();
        } catch (PDOException $ex) {
            echo $commit = 0;
        } catch (Exception $ex) {
            echo $commit = 0;
        }
        return $commit;
    }
    public static function closeGdcStockDetails() {
        $commit = 1;
        self::$db->beginTransaction();
        if ($commit == 1) {
            $commit = self::closeGdc();
        }
        if ($commit === 1) {
            $gdcOutId = generalhelper::getGetElement('gdcOutId');
            $commit = self::closeGdcIn($gdcOutId);
        }
        if ($commit === 1) {
            $gdcInLastId = self::$db->lastInsertId();
            self::$gdcInLastId = $gdcInLastId;
            $gdcOutId = generalhelper::getGetElement('gdcOutId');
            $commit = self::closeGdcInItems($gdcOutId);
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function closeGdc() {
        $gdcOutId = generalhelper::getGetElement('gdcOutId');
        $commit = 1;
        try {
            $gdcCloseSql = "update " . table_gdc_out . " set "
                    . gdc_out_status . "= 1 where "
                    . gdc_out_id . "= " . $gdcOutId;
            $gdcUpdate = self::$db->prepare($gdcCloseSql);
            $gdcUpdate->execute(array(':' . gdc_out_id => $gdcOutId));
        } catch (PDOException $ex) {
            echo $commit = 0;
        }
        return $commit;
    }
    
    public static function closeGdcIn($gdcOutId) {
        $commit = 1;
        try {

            $lineGdcItemId = generalhelper::getGetElementArray('lineproductId');
            $receivedDate = generalhelper::getGetElementArray('receivedDate');
            $receivedPerson = generalhelper::getGetElementArray('receivedPerson');
            $deliveryPerson = generalhelper::getGetElementArray('deliveryPerson');
            $insert_values = array();
            $datafields = array(gdc_in_gdcOutRefId, gdc_in_date,
                gdc_in_receivedPerson,gdc_in_deliveryPerson,gdc_in_createdTimeStamp
            );
            for ($increment = 0; $increment < count($lineGdcItemId); $increment++) {
                if ($lineGdcItemId[$increment] != 0) {
                    $datafieldsValue = array(
                        gdc_in_gdcOutRefId => $gdcOutId,
                        gdc_in_date => $receivedDate[$increment],
                        gdc_in_receivedPerson => $receivedPerson[$increment],
                        gdc_in_deliveryPerson => $deliveryPerson[$increment],
                        gdc_in_createdTimeStamp => date("Y-m-d H:i:s")
                    );
                    $insert_values = array_merge($insert_values, array_values($datafieldsValue));
                    $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($datafields)) . ')';
                }
            }
             $sql = "INSERT INTO " . table_gdc_in . "(" . implode(",", $datafields) . ") VALUES " . implode(',', $question_marks);
            $query = self::$db->prepare($sql);
            $query->execute($insert_values);
        } catch (PDOException $ex) {
            echo $ex;
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex;
        }
        return $commit;
    }

    public static function closeGdcInItems($gdcOutId) {
        $commit = 1;
        try {

            $lastId = self::$gdcInLastId;
            $lineGdcItemId = generalhelper::getGetElementArray('lineproductId');
            $returnQuantity = generalhelper::getGetElementArray('receiveQty');
            $inItemDescription = generalhelper::getGetElementArray('returnDescription');
            $insert_values = array();
            $datafields = array(gdcinItems_gdcInRefId,gdcinItems_gdcOutRefId, gdcinItems_gdcOutItemRefId,
                gdcinItems_receivedQuantity,gdcinItems_description,gdcinItems_createdTimeStamp
            );
            for ($increment = 0; $increment < count($lineGdcItemId); $increment++) {
                if ($lineGdcItemId[$increment] != 0) {
                    $datafieldsValue = array(
                        gdcinItems_gdcInRefId => $lastId,
                        gdcinItems_gdcOutRefId => $gdcOutId,
                        gdcinItems_gdcOutItemRefId => $lineGdcItemId[$increment],
                        gdcinItems_receivedQuantity => $returnQuantity[$increment],
                        gdcinItems_description => $inItemDescription[$increment],
                        gdcinItems_createdTimeStamp => date("Y-m-d H:i:s")
                    );
                    $insert_values = array_merge($insert_values, array_values($datafieldsValue));
                    $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($datafields)) . ')';
                }
            }
             $sql = "INSERT INTO " . table_gdc_initems . "(" . implode(",", $datafields) . ") VALUES " . implode(',', $question_marks);
            $query = self::$db->prepare($sql);
            $query->execute($insert_values);
        } catch (PDOException $ex) {
            echo $ex;
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex;
        }
        return $commit;
    }
    public static function getGdcCompanyDetails() {
        echo $sql = " select a." . gdc_out_companyname . " ,a." . gdc_out_id . " from " . table_gdc_out . " as a where a." . gdc_out_status ." = 1 group by " . gdc_out_companyname;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function getGdcStockItemDetails() {
        $sql = "select a." . gdcoutItems_itemId . ",b." . items_name . " from " . table_gdc_outitems .
                " as a inner join " . table_items . " as b on b." . items_item_id . " = a." . gdcoutItems_itemId .
                " group by a." . gdcoutItems_itemId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public static function getGdcStockReports() {

        $fromDate = generalhelper::getGetElement('fromDate');
        $toDate = generalhelper::getGetElement('toDate');
        $item_id = generalhelper::getGetElement('itemId');
        if ($item_id == "-1") {
            $sql = "SELECT a.*,b.*,c.`NAME`,d.receivedQuantity,(b.takenQuantity - d.receivedQuantity) as pending from gdcout as a 
INNER JOIN gdcoutitems as b on b.gdcOutRefId = a.gdcOutId
INNER JOIN items as c on c.ItemId = b.itemId
INNER JOIN gdcinitems as d on d.gdcOutRefId = a.gdcOutId
where a.gdcOutDate BETWEEN '$fromDate' and '$toDate'";
        } else {
            $sql = "SELECT a.*,b.*,c.`NAME`,d.receivedQuantity,(b.takenQuantity - d.receivedQuantity) as pending from gdcout as a 
INNER JOIN gdcoutitems as b on b.gdcOutRefId = a.gdcOutId
INNER JOIN items as c on c.ItemId = $item_id
INNER JOIN gdcinitems as d on d.gdcOutRefId = a.gdcOutId
where a.gdcOutDate BETWEEN '$fromDate' and '$toDate'";


            $query = self::$db->prepare($sql);
            $query->execute();

            return $query->fetchAll();
        }
    }
    public static function getGdcStockItemDetailsById($itemId) {
        $sql = " select a." . items_name . " from " . table_items . " as a where a." . items_item_id . "= $itemId";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

}
