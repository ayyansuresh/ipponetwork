<?php

class gdcModel extends Controller {

    public static $salesBillItemLastId = 0;
    public static $salesBillId = 0;
    public static $salesBillItemCount = 0;

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
            $gdcId = self::$db->lastInsertId();
            $commit = self::saveGdcItems($gdcId);
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

            $sql = "insert into " . table_gdc . "(" . gdc_vanId
                    . "," . gdc_staffName
                    . "," . gdc_status
                    . "," . gdc_date
                    . "," . gdc_created_timetamp
                    . ")"
                    . " values (:" . gdc_vanId
                    . ",:" . gdc_staffName
                    . ",:" . gdc_status
                    . ",:" . gdc_date
                    . ",NOW()"
                    . ")";
            $query = self::$db->prepare($sql);
            $parameter = array(
                ':' . gdc_vanId => generalhelper::getGetElement('vanId'),
                ':' . gdc_staffName => generalhelper::getGetElement('staffName'),
                ':' . gdc_status => 0,
                ':' . gdc_date => generalhelper::getGetElement('gdcDate')
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

    public static function saveGdcItems($gdcId) {
        $commit = 1;
        try {
            $lineproductId = generalhelper::getGetElementArray('lineproductId');
            $uomId = generalhelper::getGetElementArray('uomId');
            $takenQuantity = generalhelper::getGetElementArray('takenQuantity');
            $insert_values = array();
            $datafields = array(gdcItems_gdcRefId, gdcItems_itemId,
                gdcItems_uomId, gdcItems_takenQuantity,
                gdcItems_returnQuantity, gdcItems_salesQuantity
            );
            for ($increment = 0; $increment < count($lineproductId); $increment++) {
                if ($lineproductId[$increment] != 0) {
                    $datafieldsValue = array(gdcItems_gdcRefId => $gdcId,
                        gdcItems_itemId => $lineproductId[$increment],
                        gdcItems_uomId => $uomId[$increment],
                        gdcItems_takenQuantity => $takenQuantity[$increment],
                        gdcItems_returnQuantity => 0,
                        gdcItems_salesQuantity => $takenQuantity[$increment]
                    );
                    $insert_values = array_merge($insert_values, array_values($datafieldsValue));
                    $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($datafields)) . ')';
                }
            }
            $sql = "INSERT INTO " . table_gdc_items . "(" . implode(",", $datafields) . ") VALUES " . implode(',', $question_marks);
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
         $sql = "select a.*,b.*,c.* from " . table_gdc_items . " as a " .
                " inner join " . table_items . " as b on a." . gdcItems_itemId . " = b." .
                items_item_id .
                " inner join " . table_uom . " as c on a." . gdcItems_uomId . " = c." .
                uom_id .
                " where a." . gdcItems_gdcRefId . " = " . $gdcId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function updateGdcDetails() {
        $commit = 1;
        self::$db->beginTransaction();
        $commit = self::deleteGdc();
        if ($commit == 1) {
            $commit = self::addNewGdc();
        }
        if ($commit === 1) {
            $gdcId = self::$db->lastInsertId();
            $commit = self::saveGdcItems($gdcId);
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function deleteGdc() {
        $gdcId = generalhelper::getGetElement('gdcId');
        $commit = 1;
        try {
            $gdcDeleteSql = "delete a.* from " . table_gdc . " as a "
                    . "where a." . gdc_id . "=" . $gdcId;

            $gdcDelete = self::$db->prepare($gdcDeleteSql);
            $gdcDelete->execute();

            $gdcItemDeleteSql = "delete  from " . table_gdc_items . " where " . gdcItems_gdcRefId . " = " . $gdcId;

            $gdcItemDelete = self::$db->prepare($gdcItemDeleteSql);
            $gdcItemDelete->execute();
        } catch (PDOException $ex) {
            echo $commit = 0;
        } catch (Exception $ex) {
            echo $commit = 0;
        }
        return $commit;
    }

    public static function closeGdcDetails() {
        $commit = 1;
        self::$db->beginTransaction();
        if ($commit == 1) {
            $commit = self::closeGdc();
        }
        if ($commit === 1) {
            $gdcId = generalhelper::getGetElement('gdcId');
            $commit = self::closeGdcItems($gdcId);
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function closeGdc() {
        $gdcId = generalhelper::getGetElement('gdcId');
        $commit = 1;
        try {
            $gdcCloseSql = "update " . table_gdc . " set "
                    . gdc_status . "= 1 where "
                    . gdc_id . "= :" . gdc_id;

            $gdcUpdate = self::$db->prepare($gdcCloseSql);
            $gdcUpdate->execute(array(':' . gdc_id => $gdcId));
        } catch (PDOException $ex) {
            echo $commit = 0;
        } catch (Exception $ex) {
            echo $commit = 0;
        }
        return $commit;
    }

    public static function closeGdcItems($gdcId) {
        $commit = 1;
        try {

            $takenQuantity = generalhelper::getGetElementArray('takenQuantity');
            $lineGdcItemId = generalhelper::getGetElementArray('lineGdcItemId');
            $returnQuantity = generalhelper::getGetElementArray('returnQuantity');
            $insert_values = array();
            $datafields = array(gdcItems_id, gdcItems_takenQuantity,
                gdcItems_returnQuantity
            );
            for ($increment = 0; $increment < count($lineGdcItemId); $increment++) {
                if ($lineGdcItemId[$increment] != 0) {
                    $datafieldsValue = array(
                        gdcItems_id => $lineGdcItemId[$increment],
                        gdcItems_takenQuantity => $takenQuantity[$increment],
                        gdcItems_returnQuantity => $returnQuantity[$increment]
                    );
                    $insert_values = array_merge($insert_values, array_values($datafieldsValue));
                    $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($datafields)) . ')';
                }
            }
            print_r($datafieldsValue);
             $sql = "INSERT INTO " . table_gdc_items . "(" . implode(",", $datafields) . ") VALUES " . implode(',', $question_marks) . " ON DUPLICATE KEY UPDATE  "
            . gdcItems_returnQuantity . " = values(" . gdcItems_returnQuantity .")"
            . "," . gdcItems_salesQuantity . " = " . gdcItems_takenQuantity . "-values(" . gdcItems_returnQuantity.")";
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

    public static function getGdcVanDetails() {
        $sql = " select * from " . table_gdc_vannumber;
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

}
