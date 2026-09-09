<?php

class purchaseorderModel extends Controller {

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

    public static function makePurchaseOrderInvoice() {
        self::$db->beginTransaction();
        $commit = self::setPurchaseOrder();
        //$billType = generalhelper::getGetElement('billType');
        if ($commit === 1) {
            $commit = self::setPurchaseOrderItems();
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function setPurchaseOrder() {
        $commit = 1;
        try {
            if (generalhelper::getGetElement('billType') == 3) {
                $addressID = 0;
                $customerId = 1;
            } else {
                $addressIDsql = "select " . customeraddress_address_id . " as AddressId from " . table_customer_address . " where " .
                        customeraddress_customer_ref_id . " = " . generalhelper::getGetElement('customerName') .
                        " and " . customeraddress_address_type . " = 1 and " . customeraddress_active_flag . " = 1";
                $addressIDQuery = self::$db->prepare($addressIDsql);
                $addressIDQuery->execute();
                $addressID = $addressIDQuery->fetch()->AddressId;
                $customerId = generalhelper::getGetElement('customerName');
            }
            $sql = "insert into " . table_purchaseorder . "(" . purchaseorder_purchaseorderNumber . ","
                    . purchaseorder_purchaseorderDisplayNumber . "," . purchaseorder_purchaseorderDate
                    . "," . purchaseorder_customer_id . "," . purchaseorder_cgst_total . "," . purchaseorder_sgst_total
                    . "," . purchaseorder_igst_total
                    . "," . purchaseorder_running_total . "," . purchaseorder_round_off
                    . "," . purchaseorder_purchaseorderTotal . "," . purchaseorder_company_ref_id . "," . purchaseorder_account_year_ref_id
                    . "," . purchaseorder_created_by . "," . purchaseorder_created_timetamp . "," . purchaseorder_purchaseorderType . "," . purchaseorder_purchaseorderStatus
                    . "," . purchaseorder_purchaseorderStage . "," . purchaseorder_purchaseorderLock . "," . purchaseorder_purchaseorderGSTType
                    . "," . purchaseorder_transport . "," . purchaseorder_bundle
                    . "," . purchaseorder_total_discount . "," . purchaseorder_product_discount
                    . "," . purchaseorder_address_id . "," . purchaseorder_account_ref_id . "," . purchaseorder_vat_cst_flag
                    . ")"
                    . " values (:" . purchaseorder_purchaseorderNumber
                    . ",:" . purchaseorder_purchaseorderDisplayNumber . ",:" . purchaseorder_purchaseorderDate
                    . ",:" . purchaseorder_customer_id . ",:" . purchaseorder_cgst_total . ",:" . purchaseorder_sgst_total
                    . ",:" . purchaseorder_igst_total
                    . ",:" . purchaseorder_running_total . ",:" . purchaseorder_round_off
                    . ",:" . purchaseorder_purchaseorderTotal . ",:" . purchaseorder_company_ref_id . ",:" . purchaseorder_account_year_ref_id
                    . ",:" . purchaseorder_created_by . ",NOW(),:" . purchaseorder_purchaseorderType . ",:" . purchaseorder_purchaseorderStatus
                    . ",:" . purchaseorder_purchaseorderStage . ",:" . purchaseorder_purchaseorderLock . ",:" . purchaseorder_purchaseorderGSTType
                    . ",:" . purchaseorder_transport . ",:" . purchaseorder_bundle
                    . ",:" . purchaseorder_total_discount . ",:" . purchaseorder_product_discount
                    . ",:" . purchaseorder_address_id . ",:" . purchaseorder_account_ref_id . ",:" . purchaseorder_vat_cst_flag
                    . ")";
            $query = self::$db->prepare($sql);
            $parameter = array(
                ':' . purchaseorder_purchaseorderNumber => generalhelper::getGetElement('despatch'),
                ':' . purchaseorder_purchaseorderDisplayNumber => generalhelper::getGetElement('despatch'),
                ':' . purchaseorder_purchaseorderDate => generalhelper::getGetElement('billDate'),
                ':' . purchaseorder_customer_id => $customerId,
                ':' . purchaseorder_cgst_total => generalhelper::getGetElement('cgstvalue'),
                ':' . purchaseorder_sgst_total => generalhelper::getGetElement('sgstvalue'),
                ':' . purchaseorder_igst_total => generalhelper::getGetElement('igstvalue'),
                ':' . purchaseorder_running_total => generalhelper::getGetElement('subtotal'),
                ':' . purchaseorder_round_off => generalhelper::getGetElement('roundOff'),
                ':' . purchaseorder_purchaseorderTotal => generalhelper::getGetElement('grandTotal'),
                ':' . purchaseorder_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                ':' . purchaseorder_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                ':' . purchaseorder_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                ':' . purchaseorder_purchaseorderType => generalhelper::getGetElement('billType'),
                ':' . purchaseorder_purchaseorderStatus => 3,
                ':' . purchaseorder_purchaseorderStage => 1,
                ':' . purchaseorder_purchaseorderLock => 0,
                ':' . purchaseorder_purchaseorderGSTType => generalhelper::getGetElement('billGSTType'),
                ':' . purchaseorder_transport => generalhelper::getGetElement('transportName'),
                ':' . purchaseorder_bundle => generalhelper::getGetElement('bundle'),
                ':' . purchaseorder_total_discount => 0,
                ':' . purchaseorder_product_discount => 0,
                ':' . purchaseorder_address_id => $addressID,
                ':' . purchaseorder_account_ref_id => generalhelper::getGetElement('bankaccount'),
                ':' . purchaseorder_vat_cst_flag => 0
            );
            $query->execute($parameter);
            self::$salesBillId = self::$db->lastInsertId();
        } catch (PDOException $ex) {
            $commit = 0;
            echo $ex;
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex;
        }
        return $commit;
    }

    public static function setPurchaseOrderItems() {
        $commit = 1;
        try {
            $linetotal = generalhelper::getGetElementArray('linetotal');
            $linecgstrate = generalhelper::getGetElementArray('linecgstrate');
            $linesgstrate = generalhelper::getGetElementArray('linesgstrate');
            $lineigstrate = generalhelper::getGetElementArray('lineigstrate');
            $linequantity = generalhelper::getGetElementArray('linequantity');
            $linerate = generalhelper::getGetElementArray('linerate');
            $linehsncode = generalhelper::getGetElementArray('linehsncode');
            $lineproductId = generalhelper::getGetElementArray('lineproductid');
            $lineUOM = generalhelper::getGetElementArray('lineUOM');
            $linepackingfactor = generalhelper::getGetElementArray('linepackingfactor');
            $linecommodityRefId = generalhelper::getGetElementArray('linecommodityRefId');
            $linenumberofbags = generalhelper::getGetElementArray('linenumberofbags');
            $lineDiscount = generalhelper::getGetElementArray('linediscount');
            $lineUnitRateWithTax = generalhelper::getGetElementArray('lineunitratewithtax');
            $linetotalwithtax = generalhelper::getGetElementArray('linetotalwithtax');
            self::$salesBillItemCount = count($linetotal);
            $insert_values = array();
            $datafields = array(purchaseorderitem_purchaseorderRefId, purchaseorderitem_purchaseorderDate,
                purchaseorderitem_item_ref_id, purchaseorderitem_unit_rate,
                purchaseorderitem_Discount, purchaseorderitem_quantity,
                purchaseorderitem_total, purchaseorderitem_chess_rate, purchaseorderitem_chess_total,
                purchaseorderitem_cgst_rate, purchaseorderitem_cgst_total,
                purchaseorderitem_sgst_rate, purchaseorderitem_sgst_total,
                purchaseorderitem_igst_rate, purchaseorderitem_igst_total,
                purchaseorderitem_UOM_ref_id, purchaseorderitem_packing_factor,
                purchaseorderitem_total_UOM_quantity, purchaseorderitem_hsn_code_ref_id,
                purchaseorderitem_purchaseorderCustomerRefId, purchaseorderitem_company_ref_id,
                purchaseorderitem_account_year_ref_id, purchaseorderitem_purchaseorderType,
                purchaseorderitem_purchaseorderGSTType, purchaseorderitem_commodity_ref_id,
                purchaseorderitem_unitrate_wittax,
                purchaseorderitem_total_withtax
            );
            for ($increment = 0; $increment < count($linetotal); $increment++) {
                $linecgsttotal = $linecgstrate[$increment] * $linequantity[$increment] * $linerate[$increment] / 100;
                $linesgsttotal = $linesgstrate[$increment] * $linequantity[$increment] * $linerate[$increment] / 100;
                $lineigsttotal = $lineigstrate[$increment] * $linequantity[$increment] * $linerate[$increment] / 100;
                $linecgsttotal = round($linecgsttotal, 2);
                $linesgsttotal = round($linesgsttotal, 2);
                $lineigsttotal = round($lineigsttotal, 2);
                $linUOMQuanity = $linequantity[$increment] * $linepackingfactor[$increment];
                if ($lineproductId[$increment] != 0) {
                    $datafieldsValue = array(purchaseorderitem_purchaseorderRefId => self::$salesBillId,
                        purchaseorderitem_purchaseorderDate => generalhelper::getGetElement('billDate'),
                        purchaseorderitem_item_ref_id => $lineproductId[$increment],
                        purchaseorderitem_unit_rate => $linerate[$increment],
                        purchaseorderitem_Discount => $lineDiscount[$increment],
                        purchaseorderitem_quantity => $linequantity[$increment],
                        purchaseorderitem_total => $linetotal[$increment],
                        purchaseorderitem_chess_rate => 0,
                        purchaseorderitem_chess_total => 0,
                        purchaseorderitem_cgst_rate => $linecgstrate[$increment],
                        purchaseorderitem_cgst_total => $linecgsttotal,
                        purchaseorderitem_sgst_rate => $linesgstrate[$increment]
                        , purchaseorderitem_sgst_total => $linesgsttotal,
                        purchaseorderitem_igst_rate => $lineigstrate[$increment],
                        purchaseorderitem_igst_total => $lineigsttotal,
                        purchaseorderitem_UOM_ref_id => $lineUOM[$increment],
                        purchaseorderitem_packing_factor => $linepackingfactor[$increment],
                        purchaseorderitem_total_UOM_quantity => $linUOMQuanity,
                        purchaseorderitem_hsn_code_ref_id => $linehsncode[$increment],
                        purchaseorderitem_purchaseorderCustomerRefId => generalhelper::getGetElement('customerName'),
                        purchaseorderitem_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                        purchaseorderitem_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                        purchaseorderitem_purchaseorderType => generalhelper::getGetElement('billType'),
                        purchaseorderitem_purchaseorderGSTType => generalhelper::getGetElement('billGSTType'),
                        purchaseorderitem_commodity_ref_id => $linecommodityRefId[$increment],
                        purchaseorderitem_unitrate_wittax => $lineUnitRateWithTax[$increment],
                        purchaseorderitem_total_withtax => $linetotalwithtax[$increment]
                    );
                    $insert_values = array_merge($insert_values, array_values($datafieldsValue));
                    $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($datafields)) . ')';
                }
            }
            $sql = "INSERT INTO " . table_purchaseorderitem . "(" . implode(",", $datafields) . ") VALUES " . implode(',', $question_marks);
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

    public static function getPoDetailsByNumber() {
        $gstBillType = generalhelper::getGetElement('gstType');
        $billNumber = generalhelper::getGetElement('billNumber');
        //$vatCstFlag = generalhelper::getGetElement('vatCstFlag');

        $sql = "select a.*,b.*,c." . city_name . " as cityName, d." . state_name . " as stateName, e." . country_name . " as countryName from " . table_purchaseorder . " as a " .
                " inner join " . table_customershipmentaddress . " as b on a." . purchaseorder_customer_id . " = b." . customershippmentaddress_customer_ref_id .
                " inner join " . table_city . " as c on c." . city_id . " = b." . customershippmentaddress_city_ref_id .
                " inner join " . table_state . " as d on d." . state_id . " = b." . customershippmentaddress_state_ref_id .
                " inner join " . table_country . " as e on e." . country_id . " = b." . customershippmentaddress_country_ref_id .
                " where a." . purchaseorder_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid') .
                " and a." . purchaseorder_account_year_ref_id . " = " . generalhelper::getSessionElement('beebookloginaccountyearid') .
                " and a." . purchaseorder_purchaseorderStatus . " = " . 3 .
                " and a." . purchaseorder_purchaseorderGSTType . " = " . $gstBillType .
                " and a." . purchaseorder_purchaseorderNumber . " = '" . $billNumber . "'";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getPoItem($poId) {
        $gstBillType = generalhelper::getGetElement('gstType');
        $sql = "select a.*,b.*,c.*,sum(d." . salesbillitem_quantity . ") as salesQty from " . table_purchaseorderitem . " as a " .
                " inner join " . table_items . " as b on a." . purchaseorderitem_item_ref_id . " = b." .
                items_item_id .
                " inner join " . table_commodity . " as c on c." . commodity_id . " = a." . purchaseorderitem_commodity_ref_id .
                " left join " . table_sales_bill_item . " as d on d." . salesbillitem_purchaseOrderItemRefId . " = a." . purchaseorderitem_id .
                " and d." . salesbillitem_purchaseOrderRefId . " = " . $poId .
                " where a." . purchaseorderitem_purchaseorderRefId . " = " . $poId .
                " and a." . purchaseorderitem_purchaseorderGSTType . " = " . $gstBillType .
                " group by a." . purchaseorderitem_id;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function makePoSalesInvoice() {
        self::$db->beginTransaction();
        $commit = self::addSalesBill();
        $salesBillLastId = self::$db->lastInsertId();
        $billType = generalhelper::getGetElement('billType');
        if ($commit === 1) {
            $commit = self::saveInvoiceItems();
        }
        if ($commit == 1) {
            $salesBillItemLastId = self::$db->lastInsertId();
            self::$salesBillItemLastId = $salesBillItemLastId;
            $commit = self::saveStock();
        }
        if ($commit == 1) {
            $commit = self::saveDayTransaction();
        }
        if ($commit == 1 && ($billType == 2 || $billType == 3)) {
            $commit = self::saveAccountTransaction();
        }
        if ($commit == 1) {
            $commit = self::saveCustomerTransaction();
        }
        if ($commit == 1) {
            $commit = self::addSalesShipmentAddress($salesBillLastId);
        }
        //if ($commit == 1) {
        //    $commit = self::updatePurchaseOrder();
        //}
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function addSalesBill() {
        $commit = 1;
        try {
            $billNumber = self::getLastBillNumber(generalhelper::getGetElement('billGSTType')) + 1;
            ?>
            <script>
                $("#billNumber").val(<?php echo $billNumber; ?>);
            </script>

            <?php
            // $billNumberDisplay = self::getBillPrefix(generalhelper::getGetElement('billGSTType'));
            // $displayNumber = str_pad($billNumber, $billNumberDisplay[sales_prefix_digit], '0', STR_PAD_LEFT);
            // $billDisplay = $billNumberDisplay[sales_prefix_value] . $displayNumber;
            $billDisplay = 'CVI-' . $billNumber . '/2018-2019';
            if (generalhelper::getGetElement('billType') == 3) {
                $addressID = 0;
                $customerId = 1;
            } else {
                $addressIDsql = "select " . customeraddress_address_id . " as AddressId from " . table_customer_address . " where " .
                        customeraddress_customer_ref_id . " = " . generalhelper::getGetElement('customerName') .
                        " and " . customeraddress_address_type . " = 1 and " . customeraddress_active_flag . " = 1";
                $addressIDQuery = self::$db->prepare($addressIDsql);
                $addressIDQuery->execute();
                $addressID = $addressIDQuery->fetch()->AddressId;
                $customerId = generalhelper::getGetElement('customerName');
            }
            $sql = "insert into " . table_sales_bill . "(" . salesbill_sales_bill_number . ","
                    . salesbill_sales_bill_display_number . "," . salesbill_sales_bill_date
                    . "," . salesbill_customer_id . "," . salesbill_cgst_total . "," . salesbill_sgst_total
                    . "," . salesbill_igst_total
                    . "," . salesbill_running_total . "," . salesbill_round_off
                    . "," . salesbill_sales_bill_total . "," . salesbill_company_ref_id . "," . salesbill_account_year_ref_id
                    . "," . salesbill_created_by . "," . salesbill_created_timetamp . "," . salesbill_sales_bill_type
                    . "," . salesbill_sales_bill_stage . "," . salesbill_sales_bill_lock . "," . salesbill_gst_type
                    . "," . salesbill_transport . "," . salesbill_bundle
                    . "," . salesbill_total_discount . "," . salesbill_product_discount
                    . "," . salesbill_address_id . "," . salesbill_account_ref_id . "," . salesbill_vat_cst_flag
                    . "," . salesbill_despatched_to . "," . salesbill_lorry_number . "," . salesbill_document_through
                    . "," . salesbill_packing_charge . "," . salesbill_postage_charge . "," . salesbill_purchaseOrderRefId .
                    "," . salesbill_ewayBillNumber . "," . salesbill_totalNumberOfBags
                    . ")"
                    . " values (:" . salesbill_sales_bill_number
                    . ",:" . salesbill_sales_bill_display_number . ",:" . salesbill_sales_bill_date
                    . ",:" . salesbill_customer_id . ",:" . salesbill_cgst_total . ",:" . salesbill_sgst_total
                    . ",:" . salesbill_igst_total
                    . ",:" . salesbill_running_total . ",:" . salesbill_round_off
                    . ",:" . salesbill_sales_bill_total . ",:" . salesbill_company_ref_id . ",:" . salesbill_account_year_ref_id
                    . ",:" . salesbill_created_by . ",NOW(),:" . salesbill_sales_bill_type
                    . ",:" . salesbill_sales_bill_stage . ",:" . salesbill_sales_bill_lock . ",:" . salesbill_gst_type
                    . ",:" . salesbill_transport . ",:" . salesbill_bundle
                    . ",:" . salesbill_total_discount . ",:" . salesbill_product_discount
                    . ",:" . salesbill_address_id . ",:" . salesbill_account_ref_id . ",:" . salesbill_vat_cst_flag
                    . ",:" . salesbill_despatched_to . ",:" . salesbill_lorry_number . ",:" . salesbill_document_through
                    . ",:" . salesbill_packing_charge . ",:" . salesbill_postage_charge . ",:" . salesbill_purchaseOrderRefId .
                    ",:" . salesbill_ewayBillNumber . ",:" . salesbill_totalNumberOfBags .
                    ")";
            $query = self::$db->prepare($sql);
            $parameter = array(
                ':' . salesbill_sales_bill_number => $billNumber,
                ':' . salesbill_sales_bill_display_number => $billDisplay,
                ':' . salesbill_sales_bill_date => generalhelper::getGetElement('billDate'),
                ':' . salesbill_customer_id => $customerId,
                ':' . salesbill_cgst_total => generalhelper::getGetElement('cgstvalue'),
                ':' . salesbill_sgst_total => generalhelper::getGetElement('sgstvalue'),
                ':' . salesbill_igst_total => generalhelper::getGetElement('igstvalue'),
                ':' . salesbill_running_total => generalhelper::getGetElement('subtotal'),
                ':' . salesbill_round_off => generalhelper::getGetElement('roundOff'),
                ':' . salesbill_sales_bill_total => generalhelper::getGetElement('grandTotal'),
                ':' . salesbill_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                ':' . salesbill_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                ':' . salesbill_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                ':' . salesbill_sales_bill_type => generalhelper::getGetElement('billType'),
                ':' . salesbill_sales_bill_stage => 1,
                ':' . salesbill_sales_bill_lock => 0,
                ':' . salesbill_gst_type => generalhelper::getGetElement('billGSTType'),
                ':' . salesbill_transport => generalhelper::getGetElement('transportName'),
                ':' . salesbill_bundle => generalhelper::getGetElement('bundle'),
                ':' . salesbill_total_discount => 0,
                ':' . salesbill_product_discount => 0,
                ':' . salesbill_address_id => $addressID,
                ':' . salesbill_account_ref_id => generalhelper::getGetElement('bankaccount'),
                ':' . salesbill_vat_cst_flag => 0,
                ':' . salesbill_despatched_to => generalhelper::getGetElement('despatch'),
                ':' . salesbill_lorry_number => generalhelper::getGetElement('lrr'),
                ':' . salesbill_document_through => generalhelper::getGetElement('document'),
                ':' . salesbill_packing_charge => generalhelper::getGetElement('packing'),
                ':' . salesbill_postage_charge => generalhelper::getGetElement('postage'),
                ':' . salesbill_purchaseOrderRefId => generalhelper::getGetElement('poId'),
                ':' . salesbill_ewayBillNumber => generalhelper::getGetElement('ewayBillNumber'),
                ':' . salesbill_totalNumberOfBags => generalhelper::getGetElement('totalNumberOffBags')
            );
            $query->execute($parameter);
            self::$salesBillId = self::$db->lastInsertId();

            if (generalhelper::getGetElement('billType') == 3) {
                $sql = "insert into " . table_village_customer . "(" . village_billType . ","
                        . village_customerName . "," . village_customerTown
                        . "," . village_billRefId
                        . ")"
                        . " values (:" . village_billType
                        . ",:" . village_customerName . ",:" . village_customerTown
                        . ",:" . village_billRefId . ")";
                $query = self::$db->prepare($sql);
                $parameter = array(':' . village_billType => salesBill,
                    ':' . village_customerName => generalhelper::getGetElement('villagecustomerName'),
                    ':' . village_customerTown => generalhelper::getGetElement('villagecustomerCity'),
                    ':' . village_billRefId => self::$salesBillId);
                $query->execute($parameter);
            }
        } catch (PDOException $ex) {
            $commit = 0;
            echo $ex;
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex;
        }
        return $commit;
    }

    public static function getLastBillNumber($gstType) {
        $sql = "select max(" . salesbill_sales_bill_number . ") as lastBillNumber from " . table_sales_bill . " where "
                . salesbill_company_ref_id . " = :" . salesbill_company_ref_id .
                " and " . salesbill_account_year_ref_id . " = :" . salesbill_account_year_ref_id;
        $query = self::$db->prepare($sql);
        $query->execute(array(':' . salesbill_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
            ':' . salesbill_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
        ));
        return $query->fetch()->lastBillNumber;
    }

    public static function saveInvoiceItems() {
        $commit = 1;
        try {
            $poId = generalhelper::getGetElement('poId');
            $linetotal = generalhelper::getGetElementArray('linetotalwithtax');
            $linecgstrate = generalhelper::getGetElementArray('linecgstrate');
            $linesgstrate = generalhelper::getGetElementArray('linesgstrate');
            $lineigstrate = generalhelper::getGetElementArray('lineigstrate');
            $linequantity = generalhelper::getGetElementArray('linequantity');
            $linerate = generalhelper::getGetElementArray('linerate');
            $linehsncode = generalhelper::getGetElementArray('linehsncode');
            $lineproductId = generalhelper::getGetElementArray('lineproductid');
            $lineUOM = generalhelper::getGetElementArray('lineUOM');
            $linepackingfactor = generalhelper::getGetElementArray('linepackingfactor');
            $linecommodityRefId = generalhelper::getGetElementArray('linecommodityRefId');
            $linenumberofbags = generalhelper::getGetElementArray('linenumberofbags');
            $lineDiscount = generalhelper::getGetElementArray('linediscount');
            $lineUnitRateWithTax = generalhelper::getGetElementArray('lineunitratewithtax');
            $linetotalwithtax = generalhelper::getGetElementArray('linetotalwithtax');
            $purchaseOrderItemRefId = generalhelper::getGetElementArray('purchaseOrderItemRefId');
            self::$salesBillItemCount = count($linetotal);
            $insert_values = array();
            $datafields = array(salesbillitem_sales_bill_ref_id, salesbillitem_sales_bill_date,
                salesbillitem_item_ref_id, salesbillitem_unit_rate,
                salesbillitem_Discount, salesbillitem_quantity,
                salesbillitem_total, salesbillitem_chess_rate, salesbillitem_chess_total,
                salesbillitem_cgst_rate, salesbillitem_cgst_total,
                salesbillitem_sgst_rate, salesbillitem_sgst_total,
                salesbillitem_igst_rate, salesbillitem_igst_total,
                salesbillitem_UOM_ref_id, salesbillitem_packing_factor,
                salesbillitem_total_UOM_quantity, salesbillitem_hsn_code_ref_id,
                salesbillitem_sales_customer_ref_id, salesbillitem_company_ref_id,
                salesbillitem_account_year_ref_id, salesbillitem_sales_bill_type,
                salesbillitem_sales_bill_gst_type, salesbillitem_commodity_ref_id,
                salesbillitem_bags, salesbillitem_unitrate_wittax,
                salesbillitem_purchaseOrderRefId, salesbillitem_purchaseOrderItemRefId,
                salesbillitem_total_withtax
            );
            for ($increment = 0; $increment < count($linetotal); $increment++) {
                $linecgsttotal = $linecgstrate[$increment] * $linequantity[$increment] * $linerate[$increment] / 100;
                $linesgsttotal = $linesgstrate[$increment] * $linequantity[$increment] * $linerate[$increment] / 100;
                $lineigsttotal = $lineigstrate[$increment] * $linequantity[$increment] * $linerate[$increment] / 100;
                $linecgsttotal = round($linecgsttotal, 2);
                $linesgsttotal = round($linesgsttotal, 2);
                $lineigsttotal = round($lineigsttotal, 2);
                $linUOMQuanity = $linequantity[$increment] * $linepackingfactor[$increment];
                if ($lineproductId[$increment] != 0) {
                    $datafieldsValue = array(salesbillitem_sales_bill_ref_id => self::$salesBillId,
                        salesbillitem_sales_bill_date => generalhelper::getGetElement('billDate'),
                        salesbillitem_item_ref_id => $lineproductId[$increment],
                        salesbillitem_unit_rate => $linerate[$increment],
                        salesbillitem_Discount => $lineDiscount[$increment],
                        salesbillitem_quantity => $linenumberofbags[$increment],
                        salesbillitem_total => $linetotal[$increment],
                        salesbillitem_chess_rate => 0,
                        salesbillitem_chess_total => 0,
                        salesbillitem_cgst_rate => $linecgstrate[$increment],
                        salesbillitem_cgst_total => $linecgsttotal,
                        salesbillitem_sgst_rate => $linesgstrate[$increment]
                        , salesbillitem_sgst_total => $linesgsttotal,
                        salesbillitem_igst_rate => $lineigstrate[$increment],
                        salesbillitem_igst_total => $lineigsttotal,
                        salesbillitem_UOM_ref_id => $lineUOM[$increment],
                        salesbillitem_packing_factor => $linepackingfactor[$increment],
                        salesbillitem_total_UOM_quantity => $linenumberofbags[$increment],
                        salesbillitem_hsn_code_ref_id => $linehsncode[$increment],
                        salesbillitem_sales_customer_ref_id => generalhelper::getGetElement('customerName'),
                        salesbillitem_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                        salesbillitem_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                        salesbillitem_sales_bill_type => generalhelper::getGetElement('billType'),
                        salesbillitem_sales_bill_gst_type => generalhelper::getGetElement('billGSTType'),
                        salesbillitem_commodity_ref_id => $linecommodityRefId[$increment],
                        salesbillitem_bags => $linenumberofbags[$increment],
                        salesbillitem_unitrate_wittax => $lineUnitRateWithTax[$increment],
                        salesbillitem_purchaseOrderRefId => $poId,
                        salesbillitem_purchaseOrderItemRefId => $purchaseOrderItemRefId[$increment],
                        salesbillitem_total_withtax => $linetotalwithtax[$increment]
                    );
                    $insert_values = array_merge($insert_values, array_values($datafieldsValue));
                    $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($datafields)) . ')';
                }
            }
            $sql = "INSERT INTO " . table_sales_bill_item . "(" . implode(",", $datafields) . ") VALUES " . implode(',', $question_marks);
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
            $start = self::$salesBillItemLastId;
            $end = $start + self::$salesBillItemCount;
            $linequantity = generalhelper::getGetElementArray('linequantity');
            $linecommodityRefId = generalhelper::getGetElementArray('linecommodityRefId');
            $lineUOM = generalhelper::getGetElementArray('lineUOM');
            $linepackingfactor = generalhelper::getGetElementArray('linepackingfactor');
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
                        stock_date => generalhelper::getGetElement('billDate'),
                        stock_table_reference_id => salesBillItemTable,
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

    public static function saveDayTransaction() {
        $commit = 1;
        try {
            $insert_values = array();
            $billType = generalhelper::getGetElement('billType');
            $datafields = array(daytransaction_date, daytransaction_transaction_table,
                daytransaction_transaction_detail_id, daytransaction_transaction_type,
                daytransaction_active_flag, daytransaction_amount, daytransaction_customer_id,
                daytransaction_company_ref_id, daytransaction_created_by,
                daytransaction_created_timestamp, daytransaction_description,
                daytransaction_account_year_ref_id
            );
            if ($billType == 1) {
                $debitDescription = daysalesDebit . generalhelper::getGetElement('billNumberDisplay');
                $creditDescription = daysalesCredit . generalhelper::getGetElement('billNumberDisplay');
            } else {
                $debitDescription = daysalesDebitCash . generalhelper::getGetElement('billNumberDisplay');
                $creditDescription = daysalesCreditCash . generalhelper::getGetElement('billNumberDisplay');
            }
            $data[] = array(daytransaction_date => generalhelper::getGetElement('billDate'),
                daytransaction_transaction_table => salesBillTable,
                daytransaction_transaction_detail_id => self::$salesBillId,
                daytransaction_transaction_type => debit,
                daytransaction_active_flag => active,
                daytransaction_amount => generalhelper::getGetElement('grandTotal'),
                daytransaction_customer_id => generalhelper::getGetElement('customerName'),
                daytransaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                daytransaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                daytransaction_created_timestamp => date("Y-m-d H:i:s"),
                daytransaction_description => $debitDescription,
                daytransaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
            );
            $data[] = array(daytransaction_date => generalhelper::getGetElement('billDate'),
                daytransaction_transaction_table => salesBillTable,
                daytransaction_transaction_detail_id => self::$salesBillId,
                daytransaction_transaction_type => credit,
                daytransaction_active_flag => active,
                daytransaction_amount => generalhelper::getGetElement('grandTotal'),
                daytransaction_customer_id => generalhelper::getGetElement('customerName'),
                daytransaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                daytransaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                daytransaction_created_timestamp => date("Y-m-d H:i:s"),
                daytransaction_description => $creditDescription,
                daytransaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
            );
            if (($billType == 2) || ($billType == 3)) {
                $cashCreditDescription = daysalesPaymentCreditCash . generalhelper::getGetElement('billNumberDisplay');
                $data[] = array(daytransaction_date => generalhelper::getGetElement('billDate'),
                    daytransaction_transaction_table => salesBillTable,
                    daytransaction_transaction_detail_id => self::$salesBillId,
                    daytransaction_transaction_type => credit,
                    daytransaction_active_flag => active,
                    daytransaction_amount => generalhelper::getGetElement('grandTotal'),
                    daytransaction_customer_id => generalhelper::getGetElement('customerName'),
                    daytransaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                    daytransaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                    daytransaction_created_timestamp => date("Y-m-d H:i:s"),
                    daytransaction_description => $cashCreditDescription,
                    daytransaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
                );
            }

            foreach ($data as $dataInter) {
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($dataInter)) . ')';
                $insert_values = array_merge($insert_values, array_values($dataInter));
            }

            $sql = "INSERT INTO " . table_day_transaction . " (" . implode(",", $datafields)
                    . ") VALUES " . implode(',', $question_marks);

            $dayTransaction = self::$db->prepare($sql);
            $dayTransaction->execute($insert_values);
        } catch (PDOException $ex) {
            echo $ex;
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }

    public static function saveAccountTransaction() {
        $commit = 1;
        try {
            $insert_values = array();
            $datafields = array(account_transaction_date, account_transaction_type,
                account_transaction_ref_id, account_transaction_amount,
                account_transaction_mode,
                account_transaction_created_by,
                account_transaction_created_timestamp, account_transaction_description,
                account_transaction_table_reference, account_transaction_table_detail,
                account_transaction_company_ref_id, account_transaction_account_year_ref_id
            );

            $creditDescription = daysalesPaymentCreditCash . generalhelper::getGetElement('billNumberDisplay');
            $data[] = array(account_transaction_date => generalhelper::getGetElement('billDate'),
                account_transaction_type => credit,
                account_transaction_ref_id => cashInhand,
                account_transaction_amount => generalhelper::getGetElement('grandTotal'),
                account_transaction_mode => cashmode,
                account_transaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                account_transaction_created_timestamp => date("Y-m-d H:i:s"),
                account_transaction_description => $creditDescription,
                account_transaction_table_reference => salesBillTable,
                account_transaction_table_detail => self::$salesBillId,
                account_transaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                account_transaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid')
            );
            $updatAccountOpeningSql = "update " . table_account_opening
                    . " set " . account_close_balance
                    . " = " . account_close_balance . " + " . generalhelper::getGetElement('grandTotal')
                    . " , " . account_trial_balance
                    . " = " . account_trial_balance . " + " . generalhelper::getGetElement('grandTotal') .
                    " where " . account_ref_id . " = " . cashInhand .
                    " and " . account_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid')
                    . "  and " .
                    account_year_ref_id . " =  " . generalhelper::getSessionElement('beebookloginaccountyearid');
            $updatequery = self::$db->prepare($updatAccountOpeningSql);
            $updatequery->execute();

            foreach ($data as $dataInter) {
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($dataInter)) . ')';
                $insert_values = array_merge($insert_values, array_values($dataInter));
            }

            $sql = "INSERT INTO " . table_account_transaction . " (" . implode(",", $datafields)
                    . ") VALUES " . implode(',', $question_marks);

            $dayTransaction = self::$db->prepare($sql);
            $dayTransaction->execute($insert_values);
        } catch (PDOException $ex) {
            echo $ex;
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }

    public static function saveCustomerTransaction() {
        $commit = 1;
        try {
            $insert_values = array();
            $datafields = array(customer_transaction_date, customer_transaction_customer_ref_id,
                customer_transaction_bill_type, customer_transaction_type,
                customer_transaction_amount, customer_transaction_account_year_ref_id,
                customer_transaction_company_ref_id,
                customer_transaction_active_flag, customer_transaction_created_by,
                customer_transaction_createdTimestamp, customer_transaction_description,
                customer_transaction_table, customer_transaction_table_detail
            );

            $creditDescription = daysalesCredit . generalhelper::getGetElement('billNumberDisplay');
            $billType = generalhelper::getGetElement('billType');
            if ($billType == 1) {
                $debitDescription = customerDebitCreditBill . generalhelper::getGetElement('billNumberDisplay');
            } else {
                $debitDescription = customerDebitCashBill . generalhelper::getGetElement('billNumberDisplay');
            }
            $data[] = array(customer_transaction_date => generalhelper::getGetElement('billDate'),
                customer_transaction_customer_ref_id => generalhelper::getGetElement('customerName'),
                customer_transaction_bill_type => $billType,
                customer_transaction_type => credit,
                customer_transaction_amount => generalhelper::getGetElement('grandTotal'),
                customer_transaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                customer_transaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                customer_transaction_active_flag => active,
                customer_transaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                customer_transaction_createdTimestamp => date("Y-m-d H:i:s"),
                daytransaction_description => $debitDescription,
                daytransaction_transaction_table => salesBillTable,
                daytransaction_transaction_detail_id => self::$salesBillId,
            );
            if (($billType == 2) || ($billType == 3)) {
                $creditDescription = customerCreditCashBill . generalhelper::getGetElement('billNumberDisplay');
                $data[] = array(customer_transaction_date => generalhelper::getGetElement('billDate'),
                    customer_transaction_customer_ref_id => generalhelper::getGetElement('customerName'),
                    customer_transaction_bill_type => $billType,
                    customer_transaction_type => debit,
                    customer_transaction_amount => generalhelper::getGetElement('grandTotal'),
                    customer_transaction_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                    customer_transaction_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                    customer_transaction_active_flag => active,
                    customer_transaction_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                    customer_transaction_createdTimestamp => date("Y-m-d H:i:s"),
                    daytransaction_description => $creditDescription,
                    daytransaction_transaction_table => salesBillTable,
                    daytransaction_transaction_detail_id => self::$salesBillId,
                );
            }
            if ($billType == 1) {
                $updatCustomerOpeningSql = "update " . table_customer_opening_balance
                        . " set " . customer_closing_balance
                        . " = " . customer_closing_balance . " - " . generalhelper::getGetElement('grandTotal')
                        . " , " . customer_trial_balance
                        . " = " . customer_trial_balance . " - " . generalhelper::getGetElement('grandTotal') .
                        " where " . customer_opening_customerid . " = " . generalhelper::getGetElement('customerName') .
                        " and " . customer_open_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid')
                        . "  and " .
                        customer_open_account_year_id . " =  " . generalhelper::getSessionElement('beebookloginaccountyearid');
                $updatequery = self::$db->prepare($updatCustomerOpeningSql);
                $updatequery->execute();
            }

            foreach ($data as $dataInter) {
                $question_marks[] = '(' . generalhelper::placeholders('?', sizeof($dataInter)) . ')';
                $insert_values = array_merge($insert_values, array_values($dataInter));
            }

            $sql = "INSERT INTO " . table_customer_transaction . " (" . implode(",", $datafields)
                    . ") VALUES " . implode(',', $question_marks);

            $dayTransaction = self::$db->prepare($sql);
            $dayTransaction->execute($insert_values);
        } catch (PDOException $ex) {
            echo $ex;
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }

    public static function updatePurchaseOrder() {
        $poId = generalhelper::getGetElement('poId');
        $commit = 1;
        try {
            $sql = " update " . table_purchaseorder . " set " . purchaseorder_purchaseorderStatus
                    . " = " . 4 . " where " . purchaseorder_id . " = " . $poId;
            $query = self::$db->prepare($sql);
            $query->execute();
        } catch (PDOException $ex) {
            $commit = 0;
            echo $ex;
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex;
        }
        return $commit;
    }

    public static function addSalesShipmentAddress($salesBillLastId) {
        $commit = 1;
        try {
            $sql = "insert into " . table_salescustomeraddress . "(" . salescustomeraddress_customer_ref_id .
                    "," . salescustomeraddress_address1 .
                    "," . salescustomeraddress_address2 . "," . salescustomeraddress_countryName
                    . "," . salescustomeraddress_stateName .
                    "," . salescustomeraddress_cityName . "," . salescustomeraddress_pinCode .
                    "," . salescustomeraddress_salesbillRefId .
                    "," . salescustomeraddress_created_by . "," . salescustomeraddress_created_timestamp .
                    "," . salescustomeraddress_active_flag . ")"
                    . " values (:" . salescustomeraddress_customer_ref_id . ",:" . salescustomeraddress_address1 . ",:"
                    . salescustomeraddress_address2 . ",:" . salescustomeraddress_countryName .
                    ",:" . salescustomeraddress_stateName . ",:" . salescustomeraddress_cityName
                    . ",:" . salescustomeraddress_pinCode . ",:" . salescustomeraddress_salesbillRefId . ",:"
                    . salescustomeraddress_created_by . ",NOW()" . ",:" . salescustomeraddress_active_flag . ")";
            $query = self::$db->prepare($sql);
            $query->execute(array(':' . salescustomeraddress_customer_ref_id => generalhelper::getGetElement('customerName'),
                ':' . salescustomeraddress_address1 => generalhelper::getGetElement('shipmentAddress1'),
                ':' . salescustomeraddress_address2 => generalhelper::getGetElement('shipmentAddress2'),
                ':' . salescustomeraddress_countryName => generalhelper::getGetElement('shipmentCountry'),
                ':' . salescustomeraddress_stateName => generalhelper::getGetElement('shipmentState'),
                ':' . salescustomeraddress_cityName => generalhelper::getGetElement('shipmentCity'),
                ':' . salescustomeraddress_pinCode => generalhelper::getGetElement('shipmentPincode'),
                ':' . salescustomeraddress_salesbillRefId => $salesBillLastId,
                ':' . salescustomeraddress_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                ':' . salescustomeraddress_active_flag => 1
            ));
        } catch (PDOException $ex) {
            $commit = 0;
        } catch (Exception $ex) {
            $commit = 0;
        }
        return $commit;
    }

    public static function getPoSalesInvoiceDetails() {
        $frombillnumber = generalhelper::getGetElement('frombillnumber');
        $tobillnumber = generalhelper::getGetElement('tobillnumber');
        $company = generalhelper::getGetElement('company');
        $accountyear = generalhelper::getGetElement('accountYear');
        $gsttype = generalhelper::getGetElement('gstType');
        $sql = "SELECT a." . salesbill_sales_bill_id . ",a." . salesbill_sales_bill_display_number
                . ",a." . salesbill_sales_bill_number . ",a." . salesbill_sales_bill_date . ",a." . salesbill_transport . ",a." . salesbill_created_timetamp .
                ",a." . salesbill_bundle . ",a." . salesbill_product_discount . ",a." . salesbill_total_discount .
                ",a." . salesbill_cgst_total . ",a." . salesbill_sgst_total . ",a." . salesbill_igst_total . ",a." . salesbill_chess_rate . ",a." . salesbill_total_chess .
                ",a." . salesbill_running_total . ",a." . salesbill_fright . ",a." . salesbill_round_off . ",a." . salesbill_sales_bill_total . ",a." . salesbill_sales_bill_type .
                ",a." . salesbill_sales_bill_status . ",a." . salesbill_sales_bill_stage . ",a." . salesbill_gst_type . ",a." . salesbill_sales_bill_total . ",a." . salesbill_ewayBillNumber . ",a." . salesbill_totalNumberOfBags .
                ",b." . customer_aadharNumber . ",b." . customer_name . ",b." . customer_gst_number . ",b." . customer_party_gst_type . ",b." . customer_type .
                ",g.*,c." . customeraddress_address1 . " as customeraddress1, c." . customeraddress_address2 . " as customeraddress2 , d." . city_name . ",e." . state_Code . ",e." . state_name . ",f." . company_name_english . ",f." . company_name_tamil .
                ",h.*,i." . purchaseorder_id . ",i." . purchaseorder_purchaseorderNumber . ",i." . purchaseorder_purchaseorderDate . ",k." . salescustomeraddress_address1 . " as shippmentaddress1,k." . salescustomeraddress_address2 . " as shippmentaddress2 ,k." . salescustomeraddress_countryName . ",k." . salescustomeraddress_cityName . ",k." . salescustomeraddress_stateName . ",k." . salescustomeraddress_pinCode . ",k." . salescustomeraddress_mobile .
                " FROM " . table_sales_bill . " as a inner JOIN " . table_purchaseorder . " as i ON a." . salesbill_purchaseOrderRefId . " = i." . purchaseorder_id .
                " inner JOIN " . table_customer . " as b ON b." . customer_id . " = a." . salesbill_customer_id
                . " inner join " . table_customer_address . " as c on c. " . customeraddress_address_id . " =  a. " . salesbill_address_id .
                " inner JOIN " . table_city . " as d ON d." . city_id . " = c." . customeraddress_city_ref_id . " and c." . customer_active_flag . " = 1
                inner JOIN " . table_state . " as e ON e." . state_id . " = c." . customeraddress_state_ref_id . " and d." . state_active_flag . " = 1
                inner JOIN " . table_company . " as f ON f." . company_id . " = a." . salesbill_company_ref_id . " 
                inner JOIN " . table_customer_address . " as g ON g." . customeraddress_address_id . " = a." . salesbill_address_id .
                " inner JOIN " . table_salescustomeraddress . " as k ON k." . salescustomeraddress_salesbillRefId . " = a." . salesbill_sales_bill_id .
                " inner JOIN " . table_account . " as h ON h." . account_id . " = a." . salesbill_account_ref_id . "   WHERE a." . salesbill_company_ref_id . "  = " . $company . " and a." . salesbill_account_year_ref_id . "=" . $accountyear . " and a." . salesbill_gst_type . "=" . $gsttype .
                " and (" . salesbill_sales_bill_number . ">=" . $frombillnumber . " and " . salesbill_sales_bill_number .
                " <=" . $tobillnumber . ") order by a." . salesbill_sales_bill_display_number;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getPoSalesInvoiceItemDetails($billId) {
        $sql = "SELECT a.*,b.*,c.*,d.*,e.* from " . table_sales_bill_item . " as a"
                . " inner join " . table_items . " as b on a." . salesbillitem_item_ref_id .
                " = b ." . items_item_id . ""
                . " inner join " . table_commodity . " as c on c." . commodity_id .
                " = b ." . items_commodity_id . ""
                . " inner join " . table_uom . " as d on d." . uom_id .
                " = a ." . salesbillitem_UOM_ref_id . ""
                . " inner join " . table_gst_HSNCode . " as e on e." . gsthsncode_hsn_code .
                " = c ." . commodity_HSNcode_ref . ""
                . " where a." . salesbillitem_sales_bill_ref_id . " = " . $billId;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function setPoupdate() {
        self::$db->beginTransaction();
        $commit = self::setPurchaseOrderUpdate();
        if ($commit === 1) {
            $commit = self::setPurchaseOrderItems();
        }
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function setPurchaseOrderUpdate() {
        $commit = 1;
        try {
            if (generalhelper::getGetElement('billType') == 3) {
                $addressID = 0;
                $customerId = 1;
            } else {
                $addressIDsql = "select " . customeraddress_address_id . " as AddressId from " . table_customer_address . " where " .
                        customeraddress_customer_ref_id . " = " . generalhelper::getGetElement('customerName') .
                        " and " . customeraddress_address_type . " = 1 and " . customeraddress_active_flag . " = 1";
                $addressIDQuery = self::$db->prepare($addressIDsql);
                $addressIDQuery->execute();
                $addressID = $addressIDQuery->fetch()->AddressId;
                $customerId = generalhelper::getGetElement('customerName');
            }

            $purchaseorderId = generalhelper::getGetElement('purchaseOrderRefId');

            $poItemdeleteSql = "delete from " . table_purchaseorderitem . " where " . purchaseorderitem_purchaseorderRefId . " = " . $purchaseorderId;
            $poItemdelete = self::$db->prepare($poItemdeleteSql);
            $poItemdelete->execute();

            $podeleteSql = "delete from " . table_purchaseorder . " where " . purchaseorder_id . " = " . $purchaseorderId;
            $podelete = self::$db->prepare($podeleteSql);
            $podelete->execute();


            $sql = "insert into " . table_purchaseorder . "(" . purchaseorder_purchaseorderNumber . ","
                    . purchaseorder_purchaseorderDisplayNumber . "," . purchaseorder_purchaseorderDate
                    . "," . purchaseorder_customer_id . "," . purchaseorder_cgst_total . "," . purchaseorder_sgst_total
                    . "," . purchaseorder_igst_total
                    . "," . purchaseorder_running_total . "," . purchaseorder_round_off
                    . "," . purchaseorder_purchaseorderTotal . "," . purchaseorder_company_ref_id . "," . purchaseorder_account_year_ref_id
                    . "," . purchaseorder_created_by . "," . purchaseorder_created_timetamp . "," . purchaseorder_purchaseorderType . "," . purchaseorder_purchaseorderStatus
                    . "," . purchaseorder_purchaseorderStage . "," . purchaseorder_purchaseorderLock . "," . purchaseorder_purchaseorderGSTType
                    . "," . purchaseorder_transport . "," . purchaseorder_bundle
                    . "," . purchaseorder_total_discount . "," . purchaseorder_product_discount
                    . "," . purchaseorder_address_id . "," . purchaseorder_account_ref_id . "," . purchaseorder_vat_cst_flag
                    . ")"
                    . " values (:" . purchaseorder_purchaseorderNumber
                    . ",:" . purchaseorder_purchaseorderDisplayNumber . ",:" . purchaseorder_purchaseorderDate
                    . ",:" . purchaseorder_customer_id . ",:" . purchaseorder_cgst_total . ",:" . purchaseorder_sgst_total
                    . ",:" . purchaseorder_igst_total
                    . ",:" . purchaseorder_running_total . ",:" . purchaseorder_round_off
                    . ",:" . purchaseorder_purchaseorderTotal . ",:" . purchaseorder_company_ref_id . ",:" . purchaseorder_account_year_ref_id
                    . ",:" . purchaseorder_created_by . ",NOW(),:" . purchaseorder_purchaseorderType . ",:" . purchaseorder_purchaseorderStatus
                    . ",:" . purchaseorder_purchaseorderStage . ",:" . purchaseorder_purchaseorderLock . ",:" . purchaseorder_purchaseorderGSTType
                    . ",:" . purchaseorder_transport . ",:" . purchaseorder_bundle
                    . ",:" . purchaseorder_total_discount . ",:" . purchaseorder_product_discount
                    . ",:" . purchaseorder_address_id . ",:" . purchaseorder_account_ref_id . ",:" . purchaseorder_vat_cst_flag
                    . ")";
            $query = self::$db->prepare($sql);
            $parameter = array(
                ':' . purchaseorder_purchaseorderNumber => generalhelper::getGetElement('despatch'),
                ':' . purchaseorder_purchaseorderDisplayNumber => generalhelper::getGetElement('despatch'),
                ':' . purchaseorder_purchaseorderDate => generalhelper::getGetElement('billDate'),
                ':' . purchaseorder_customer_id => $customerId,
                ':' . purchaseorder_cgst_total => generalhelper::getGetElement('cgstvalue'),
                ':' . purchaseorder_sgst_total => generalhelper::getGetElement('sgstvalue'),
                ':' . purchaseorder_igst_total => generalhelper::getGetElement('igstvalue'),
                ':' . purchaseorder_running_total => generalhelper::getGetElement('subtotal'),
                ':' . purchaseorder_round_off => generalhelper::getGetElement('roundOff'),
                ':' . purchaseorder_purchaseorderTotal => generalhelper::getGetElement('grandTotal'),
                ':' . purchaseorder_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                ':' . purchaseorder_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                ':' . purchaseorder_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                ':' . purchaseorder_purchaseorderType => generalhelper::getGetElement('billType'),
                ':' . purchaseorder_purchaseorderStatus => 3,
                ':' . purchaseorder_purchaseorderStage => 1,
                ':' . purchaseorder_purchaseorderLock => 0,
                ':' . purchaseorder_purchaseorderGSTType => generalhelper::getGetElement('billGSTType'),
                ':' . purchaseorder_transport => generalhelper::getGetElement('transportName'),
                ':' . purchaseorder_bundle => generalhelper::getGetElement('bundle'),
                ':' . purchaseorder_total_discount => 0,
                ':' . purchaseorder_product_discount => 0,
                ':' . purchaseorder_address_id => $addressID,
                ':' . purchaseorder_account_ref_id => generalhelper::getGetElement('bankaccount'),
                ':' . purchaseorder_vat_cst_flag => 0
            );
            $query->execute($parameter);
            self::$salesBillId = self::$db->lastInsertId();
        } catch (PDOException $ex) {
            $commit = 0;
            echo $ex;
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex;
        }
        return $commit;
    }

    public static function getPoBillUpdateDetails() {
        $gstBillType = generalhelper::getGetElement('gstType');
        $billNumber = generalhelper::getGetElement('billNumber');

        $sql = "select a.*,b.* from " . table_sales_bill . " as a " .
                " inner join " . table_salescustomeraddress . " as b on a." . salesbill_customer_id . " = b." . salescustomeraddress_customer_ref_id .
                " where a." . salesbill_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid') .
                " and a." . salesbill_account_year_ref_id . " = " . generalhelper::getSessionElement('beebookloginaccountyearid') .
                " and a." . salesbill_gst_type . " = " . $gstBillType .
                " and a." . salesbill_sales_bill_number . " = '" . $billNumber . "'";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getPoBillItemUpdateDetails($poId) {
        $gstBillType = generalhelper::getGetElement('gstType');
        $sql = "select a.*,b.*,c.* from " . table_sales_bill_item . " as a " .
                " inner join " . table_items . " as b on a." . salesbillitem_item_ref_id . " = b." . items_item_id .
                " inner join " . table_commodity . " as c on a." . salesbillitem_commodity_ref_id . " = c." . commodity_id .
                " where a." . salesbillitem_sales_bill_ref_id . " = " . $poId .
                " and a." . salesbillitem_sales_bill_gst_type . " = " . $gstBillType .
                " group by a." . salesbillitem_id;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function getPoReportDetails() {
        $gstBillType = generalhelper::getGetElement('gstType');
        $billNumber = generalhelper::getGetElement('billNumber');
        //$vatCstFlag = generalhelper::getGetElement('vatCstFlag');

        $sql = "select a.*,b.*,c." . city_name . " as cityName, d." . state_name . " as stateName, e." . country_name . " as countryName from " . table_purchaseorder . " as a " .
                " inner join " . table_customershipmentaddress . " as b on a." . purchaseorder_customer_id . " = b." . customershippmentaddress_customer_ref_id .
                " inner join " . table_city . " as c on c." . city_id . " = b." . customershippmentaddress_city_ref_id .
                " inner join " . table_state . " as d on d." . state_id . " = b." . customershippmentaddress_state_ref_id .
                " inner join " . table_country . " as e on e." . country_id . " = b." . customershippmentaddress_country_ref_id .
                " where a." . purchaseorder_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid') .
                " and a." . purchaseorder_account_year_ref_id . " = " . generalhelper::getSessionElement('beebookloginaccountyearid') .
                " and a." . purchaseorder_purchaseorderStatus . " = " . 3 .
                " and a." . purchaseorder_purchaseorderGSTType . " = " . $gstBillType .
                " and a." . purchaseorder_purchaseorderNumber . " = '" . $billNumber . "'";
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function makePoSalesUpdateInvoice() {
        self::$db->beginTransaction();
        $commit = self::removeBill();
        $billType = generalhelper::getGetElement('billType');
        if ($commit === 1) {
            $commit = self::addSalesBillUpdate();
            $salesBillLastId = self::$db->lastInsertId();
        }
        if ($commit === 1) {
            $commit = self::saveInvoiceItems();
        }
        if ($commit == 1) {
            $salesBillItemLastId = self::$db->lastInsertId();
            self::$salesBillItemLastId = $salesBillItemLastId;
            $commit = self::saveStock();
        }
        if ($commit == 1) {
            $commit = self::saveDayTransaction();
        }
        if ($commit == 1 && ($billType == 2 || $billType == 3)) {
            $commit = self::saveAccountTransaction();
        }
        if ($commit == 1) {
            $commit = self::saveCustomerTransaction();
        }
        if ($commit == 1) {
            $commit = self::addSalesShipmentAddress($salesBillLastId);
        }
        //if ($commit == 1) {
        //    $commit = self::updatePurchaseOrder();
        //}
        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }
        return $commit;
    }

    public static function removeBill() {
        $billType = generalhelper::getGetElement('billType');
        $stockType = 2;
        $stockTableReference = 2;
        $salesBillId = generalhelper::getGetElement('billId');
        $daytransationtransactionTable = 1;
        $accountRefId = 1;
        $commit = 1;
        try {
            $billAmountSql = "select " . salesbill_sales_bill_total . " as amount," . salesbill_customer_id .
                    " as customerId from " . table_sales_bill . " where " . salesbill_sales_bill_id . " = " . $salesBillId;
            $billAmount = self::$db->prepare($billAmountSql);
            $billAmount->execute();
            $billlResult = $billAmount->fetchAll();


            $billResultFinal = (array) $billlResult[0];
            $billlValue = $billResultFinal['amount'];
            $customerId = $billResultFinal['customerId'];

            $billItemsSql = "select " . salesbillitem_total_UOM_quantity . "," . salesbillitem_commodity_ref_id .
                    " from " . table_sales_bill_item . " where " . salesbillitem_sales_bill_ref_id . " = " . $salesBillId;

            $billItems = self::$db->prepare($billItemsSql);
            $billItems->execute();
            $billItemsQuantity = $billItems->fetchAll();

            $stockDeleteSql = "delete a.* from " . table_stock . " as a
                    inner join " . table_sales_bill_item . " as b on a." . stock_table_reference_detail_id . "=b." . salesbillitem_id .
                    " and a." . stock_table_reference_id . "=" . $stockTableReference . " and
                    a." . stock_type . " = " . $stockType
                    . " inner join " . table_sales_bill . " as c on b." . salesbillitem_sales_bill_ref_id . "=c." . salesbill_sales_bill_id . " 
                    where c." . salesbill_sales_bill_id . "=" . $salesBillId;

            $stockDelete = self::$db->prepare($stockDeleteSql);
            $stockDelete->execute();

            $daytransactiondeleteSql = "delete  from " . table_day_transaction . " where " . daytransaction_transaction_table . " = " . $daytransationtransactionTable .
                    " and " . daytransaction_transaction_detail_id . "=" . $salesBillId;

            $daytransactiondelete = self::$db->prepare($daytransactiondeleteSql);
            $daytransactiondelete->execute();

            $customertransactiondeleteSql = "delete  from " . table_customer_transaction . " where " . customer_transaction_table . "=" . $daytransationtransactionTable .
                    " and " . customer_transaction_table_detail . "=" . $salesBillId;

            $customertransactiondelete = self::$db->prepare($customertransactiondeleteSql);
            $customertransactiondelete->execute();

            $accounttransactiondeleteSql = "delete  from " . table_account_transaction . " where " . account_ref_id . "=" . $accountRefId .
                    " and " . account_transaction_table_reference . "=" . $daytransationtransactionTable . " and " . account_transaction_table_detail
                    . " = " . $salesBillId;

            $accounttransactiondelete = self::$db->prepare($accounttransactiondeleteSql);
            $accounttransactiondelete->execute();

            if ($billType == 1) {
                $updateCustomerBalanceSql = "update " . table_customer_opening_balance . " set " . customer_trial_balance
                        . " = " . customer_trial_balance . " + " . $billlValue . "," . customer_closing_balance . " = "
                        . customer_closing_balance . " + " . $billlValue . " where " . customer_opening_customerid . " = " . $customerId;
                $updateCustomerBalance = self::$db->prepare($updateCustomerBalanceSql);
                $updateCustomerBalance->execute();
            } else {
                $updateAccountBalanceSql = "update " . table_account_opening . " set " . account_trial_balance
                        . " = " . account_trial_balance . " - " . $billlValue . "," . account_close_balance
                        . " = " . account_close_balance . " - " . $billlValue . " and " . account_ref_id . " = 1"
                        . " and " . account_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid') .
                        " and " . account_year_ref_id . " = " . generalhelper::getSessionElement('beebookloginaccountyearid');
                $updateAccountBalance = self::$db->prepare($updateAccountBalanceSql);
                $updateAccountBalance->execute();
            }
            foreach ($billItemsQuantity as $billItemQuantityFinal) {
                $billItemQuantityFinal = (array) $billItemQuantityFinal;
                $quantityUpdateSql = "update " . table_opening_stock . " set " . openingstock_trial_UOM_quantity . " = " . openingstock_trial_UOM_quantity
                        . " + " . $billItemQuantityFinal[salesbillitem_total_UOM_quantity] . "," . openingstock_closing_UOMQuantity . " = " . openingstock_closing_UOMQuantity
                        . " + " . $billItemQuantityFinal[salesbillitem_total_UOM_quantity] . " where " . openingstock_commodity_ref_id . " = "
                        . $billItemQuantityFinal[salesbillitem_commodity_ref_id] .
                        " and " . openingstock_company_ref_id . " = " . generalhelper::getSessionElement('beebooklogincompanyid') .
                        " and " . openingstock_account_year_ref_id . " = " . generalhelper::getSessionElement('beebookloginaccountyearid');

                $quantityUpdate = self::$db->prepare($quantityUpdateSql);
                $quantityUpdate->execute();
            }

            $billItemdeleteSql = "delete from " . table_sales_bill_item . " where " . salesbillitem_sales_bill_ref_id . " = " . $salesBillId;
            $billItemdelete = self::$db->prepare($billItemdeleteSql);
            $billItemdelete->execute();

            $billdeleteSql = "delete from " . table_sales_bill . " where " . salesbill_sales_bill_id . " = " . $salesBillId;
            $billdelete = self::$db->prepare($billdeleteSql);
            $billdelete->execute();
        } catch (PDOException $ex) {
            echo $commit = 0;
        } catch (Exception $ex) {
            echo $commit = 0;
        }
        return $commit;
    }

    public static function getPoSalesPONumber() {
        $gstType = generalhelper::getGetElement('gstType');
        $sql = "select * from " . table_purchaseorder . " where " . purchaseorder_purchaseorderGSTType . " = " . $gstType .
                " and " . purchaseorder_purchaseorderStatus . " = " . 3;
        $query = self::$db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function addSalesBillUpdate() {
        $commit = 1;
        try {
            //$billNumber = self::getLastBillNumber(generalhelper::getGetElement('billGSTType')) + 1;
           $billNumber = generalhelper::getGetElement('billNumber');
            ?>
            <script>
                $("#billNumber").val(<?php echo $billNumber; ?>);
            </script>

            <?php
            // $billNumberDisplay = self::getBillPrefix(generalhelper::getGetElement('billGSTType'));
            // $displayNumber = str_pad($billNumber, $billNumberDisplay[sales_prefix_digit], '0', STR_PAD_LEFT);
            // $billDisplay = $billNumberDisplay[sales_prefix_value] . $displayNumber;
            $billDisplay = 'CVI-' . $billNumber . '/2018-2019';
            if (generalhelper::getGetElement('billType') == 3) {
                $addressID = 0;
                $customerId = 1;
            } else {
                $addressIDsql = "select " . customeraddress_address_id . " as AddressId from " . table_customer_address . " where " .
                        customeraddress_customer_ref_id . " = " . generalhelper::getGetElement('customerName') .
                        " and " . customeraddress_address_type . " = 1 and " . customeraddress_active_flag . " = 1";
                $addressIDQuery = self::$db->prepare($addressIDsql);
                $addressIDQuery->execute();
                $addressID = $addressIDQuery->fetch()->AddressId;
                $customerId = generalhelper::getGetElement('customerName');
            }
            $sql = "insert into " . table_sales_bill . "(" . salesbill_sales_bill_number . ","
                    . salesbill_sales_bill_display_number . "," . salesbill_sales_bill_date
                    . "," . salesbill_customer_id . "," . salesbill_cgst_total . "," . salesbill_sgst_total
                    . "," . salesbill_igst_total
                    . "," . salesbill_running_total . "," . salesbill_round_off
                    . "," . salesbill_sales_bill_total . "," . salesbill_company_ref_id . "," . salesbill_account_year_ref_id
                    . "," . salesbill_created_by . "," . salesbill_created_timetamp . "," . salesbill_sales_bill_type
                    . "," . salesbill_sales_bill_stage . "," . salesbill_sales_bill_lock . "," . salesbill_gst_type
                    . "," . salesbill_transport . "," . salesbill_bundle
                    . "," . salesbill_total_discount . "," . salesbill_product_discount
                    . "," . salesbill_address_id . "," . salesbill_account_ref_id . "," . salesbill_vat_cst_flag
                    . "," . salesbill_despatched_to . "," . salesbill_lorry_number . "," . salesbill_document_through
                    . "," . salesbill_packing_charge . "," . salesbill_postage_charge . "," . salesbill_purchaseOrderRefId .
                    "," . salesbill_ewayBillNumber . "," . salesbill_totalNumberOfBags
                    . ")"
                    . " values (:" . salesbill_sales_bill_number
                    . ",:" . salesbill_sales_bill_display_number . ",:" . salesbill_sales_bill_date
                    . ",:" . salesbill_customer_id . ",:" . salesbill_cgst_total . ",:" . salesbill_sgst_total
                    . ",:" . salesbill_igst_total
                    . ",:" . salesbill_running_total . ",:" . salesbill_round_off
                    . ",:" . salesbill_sales_bill_total . ",:" . salesbill_company_ref_id . ",:" . salesbill_account_year_ref_id
                    . ",:" . salesbill_created_by . ",NOW(),:" . salesbill_sales_bill_type
                    . ",:" . salesbill_sales_bill_stage . ",:" . salesbill_sales_bill_lock . ",:" . salesbill_gst_type
                    . ",:" . salesbill_transport . ",:" . salesbill_bundle
                    . ",:" . salesbill_total_discount . ",:" . salesbill_product_discount
                    . ",:" . salesbill_address_id . ",:" . salesbill_account_ref_id . ",:" . salesbill_vat_cst_flag
                    . ",:" . salesbill_despatched_to . ",:" . salesbill_lorry_number . ",:" . salesbill_document_through
                    . ",:" . salesbill_packing_charge . ",:" . salesbill_postage_charge . ",:" . salesbill_purchaseOrderRefId .
                    ",:" . salesbill_ewayBillNumber . ",:" . salesbill_totalNumberOfBags .
                    ")";
            $query = self::$db->prepare($sql);
            $parameter = array(
                ':' . salesbill_sales_bill_number => generalhelper::getGetElement('billNumber'),
                ':' . salesbill_sales_bill_display_number => generalhelper::getGetElement('billNumberDisplay'),
                ':' . salesbill_sales_bill_date => generalhelper::getGetElement('billDate'),
                ':' . salesbill_customer_id => $customerId,
                ':' . salesbill_cgst_total => generalhelper::getGetElement('cgstvalue'),
                ':' . salesbill_sgst_total => generalhelper::getGetElement('sgstvalue'),
                ':' . salesbill_igst_total => generalhelper::getGetElement('igstvalue'),
                ':' . salesbill_running_total => generalhelper::getGetElement('subtotal'),
                ':' . salesbill_round_off => generalhelper::getGetElement('roundOff'),
                ':' . salesbill_sales_bill_total => generalhelper::getGetElement('grandTotal'),
                ':' . salesbill_company_ref_id => generalhelper::getSessionElement('beebooklogincompanyid'),
                ':' . salesbill_account_year_ref_id => generalhelper::getSessionElement('beebookloginaccountyearid'),
                ':' . salesbill_created_by => generalhelper::getSessionElement('beebookloginuserid'),
                ':' . salesbill_sales_bill_type => generalhelper::getGetElement('billType'),
                ':' . salesbill_sales_bill_stage => 1,
                ':' . salesbill_sales_bill_lock => 0,
                ':' . salesbill_gst_type => generalhelper::getGetElement('billGSTType'),
                ':' . salesbill_transport => generalhelper::getGetElement('transportName'),
                ':' . salesbill_bundle => generalhelper::getGetElement('bundle'),
                ':' . salesbill_total_discount => 0,
                ':' . salesbill_product_discount => 0,
                ':' . salesbill_address_id => $addressID,
                ':' . salesbill_account_ref_id => generalhelper::getGetElement('bankaccount'),
                ':' . salesbill_vat_cst_flag => 0,
                ':' . salesbill_despatched_to => generalhelper::getGetElement('despatch'),
                ':' . salesbill_lorry_number => generalhelper::getGetElement('lrr'),
                ':' . salesbill_document_through => generalhelper::getGetElement('document'),
                ':' . salesbill_packing_charge => generalhelper::getGetElement('packing'),
                ':' . salesbill_postage_charge => generalhelper::getGetElement('postage'),
                ':' . salesbill_purchaseOrderRefId => generalhelper::getGetElement('poId'),
                ':' . salesbill_ewayBillNumber => generalhelper::getGetElement('ewayBillNumber'),
                ':' . salesbill_totalNumberOfBags => generalhelper::getGetElement('totalNumberOffBags')
            );
            $query->execute($parameter);
            self::$salesBillId = self::$db->lastInsertId();

            if (generalhelper::getGetElement('billType') == 3) {
                $sql = "insert into " . table_village_customer . "(" . village_billType . ","
                        . village_customerName . "," . village_customerTown
                        . "," . village_billRefId
                        . ")"
                        . " values (:" . village_billType
                        . ",:" . village_customerName . ",:" . village_customerTown
                        . ",:" . village_billRefId . ")";
                $query = self::$db->prepare($sql);
                $parameter = array(':' . village_billType => salesBill,
                    ':' . village_customerName => generalhelper::getGetElement('villagecustomerName'),
                    ':' . village_customerTown => generalhelper::getGetElement('villagecustomerCity'),
                    ':' . village_billRefId => self::$salesBillId);
                $query->execute($parameter);
            }
        } catch (PDOException $ex) {
            $commit = 0;
            echo $ex;
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex;
        }
        return $commit;
    }
    
}
