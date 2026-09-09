public static function saveInvoiceProcessingError($invoiceRawDataId, $errorMessage, $data = array(), $source = 'API') {

        try {

            $sql = "INSERT INTO " . table_invoiceprocessingerror . " (
                    " . invoice_processing_error_invoice_raw_data_id . ",
                    " . invoice_processing_error_company_id . ",
                    " . invoice_processing_error_account_year_id . ",
                    " . invoice_processing_error_request_data . ",
                    " . invoice_processing_error_message . ",
                    " . invoice_processing_error_source . ",
                    " . invoice_processing_error_created_at . "
                ) VALUES (
                    :" . invoice_processing_error_invoice_raw_data_id . ",
                    :" . invoice_processing_error_company_id . ",
                    :" . invoice_processing_error_account_year_id . ",
                    :" . invoice_processing_error_request_data . ",
                    :" . invoice_processing_error_message . ",
                    :" . invoice_processing_error_source . ",
                    NOW()
                )";

            $query = self::$db->prepare($sql);

            $parameter = array(
                ':' . invoice_processing_error_invoice_raw_data_id =>
                $invoiceRawDataId,
                ':' . invoice_processing_error_company_id =>
                self::$companyid,
                ':' . invoice_processing_error_account_year_id =>
                self::$accountyearid,
                ':' . invoice_processing_error_request_data =>
                json_encode($data),
                ':' . invoice_processing_error_message =>
                $errorMessage,
                ':' . invoice_processing_error_source =>
                $source
            );

            $query->execute($parameter);

            return 1;
        } catch (PDOException $ex) {

            error_log($ex->getMessage());
            return 0;
        } catch (Exception $ex) {

            error_log($ex->getMessage());
            return 0;
        }
    }

    public static function getCompanyId($companyName) {

        try {

            $sql = "SELECT " . company_id . "
                FROM " . table_company . "
                WHERE " . company_name_english . " = :companyName
                LIMIT 1";

            $query = self::$db->prepare($sql);

            $parameter = array(
                ':companyName' => $companyName
            );

            $query->execute($parameter);

            $result = $query->fetch(PDO::FETCH_OBJ);

            if ($result) {
                return $result->company_id;
            }

            return 0;
        } catch (PDOException $ex) {

            echo $ex->getMessage();
            return 0;
        } catch (Exception $ex) {

            echo $ex->getMessage();
            return 0;
        }
    }

    public static function getAccountYearId($accountYear) {

        try {

            $sql = "SELECT " . accountyear_id . "
                FROM " . table_account_year . "
                WHERE " . accountyear_year . " = :accountYear
                LIMIT 1";

            $query = self::$db->prepare($sql);

            $parameter = array(
                ':accountYear' => $accountYear
            );

            $query->execute($parameter);

            $result = $query->fetch(PDO::FETCH_OBJ);

            if ($result) {
                return $result->accountyear_id;
            }

            return 0;
        } catch (PDOException $ex) {

            echo $ex->getMessage();
            return 0;
        } catch (Exception $ex) {

            echo $ex->getMessage();
            return 0;
        }
    }

    public static function getCompanyAndAccountYearId($data) {

        $companyId = self::getCompanyId($data['companyname']);

        if ($companyId == 0) {
            return 0;
        }

        $accountYearId = self::getAccountYearId($data['accountyear']);

        if ($accountYearId == 0) {
            return 0;
        }

        return array(
            'companyId' => $companyId,
            'accountYearId' => $accountYearId
        );
    }

    public static function addSaveDayTransaction($data, $invoiceProductDetails) {

        $commit = 1;

        try {

            $description = $data['type'] . " - Invoice No : " . $invoiceProductDetails['salesBillDisplayNumber'];

            $sql = "INSERT INTO " . table_day_transaction . " (
                    " . daytransaction_date . ",
                    " . daytransaction_transaction_table . ",
                    " . daytransaction_transaction_type . ",
                    " . daytransaction_transaction_detail_id . ",
                    " . daytransaction_transaction_description . ",
                    " . daytransaction_active_flag . ",
                    " . daytransaction_amount . ",
                    " . daytransaction_customer_id . ",
                    " . daytransaction_account_year_ref_id . ",
                    " . daytransaction_company_ref_id . ",
                    " . daytransaction_created_by . ",
                    " . daytransaction_updated_by . ",
                    " . daytransaction_created_timestamp . ",
                    " . daytransaction_updated_timestamp . "
                ) VALUES (
                    :" . daytransaction_date . ",
                    :" . daytransaction_transaction_table . ",
                    :" . daytransaction_transaction_type . ",
                    :" . daytransaction_transaction_detail_id . ",
                    :" . daytransaction_transaction_description . ",
                    :" . daytransaction_active_flag . ",
                    :" . daytransaction_amount . ",
                    :" . daytransaction_customer_id . ",
                    :" . daytransaction_account_year_ref_id . ",
                    :" . daytransaction_company_ref_id . ",
                    :" . daytransaction_created_by . ",
                    :" . daytransaction_updated_by . ",
                    NOW(),
                    NOW()
                )";


            $query = self::$db->prepare($sql);

            $parameter = array(
                ':' . daytransaction_date => $data['date'],
                ':' . daytransaction_transaction_table => salesbilltable_reference_value,
                ':' . daytransaction_transaction_type => 1,
                ':' . daytransaction_transaction_detail_id => self::$salesBillId,
                ':' . daytransaction_transaction_description => $description,
                ':' . daytransaction_active_flag => 1,
                ':' . daytransaction_amount => $data['amount'],
                ':' . daytransaction_customer_id => self::$customerId,
                ':' . daytransaction_account_year_ref_id => self::$accountyearid,
                ':' . daytransaction_company_ref_id => self::$companyid,
                ':' . daytransaction_created_by => 1,
                ':' . daytransaction_updated_by => 1
            );


            $query->execute($parameter);
        } catch (PDOException $ex) {

            $commit = 0;
            echo $ex->getMessage();
        } catch (Exception $ex) {

            $commit = 0;
            echo $ex->getMessage();
        }

        return $commit;
    }

    public static function addSaveAccountTransaction($data, $invoiceProductDetails) {

        $commit = 1;

        try {

            if ($data['paymentmode'] == "CASH") {
                $transactionmode = 1;
                $accountrefid = 1;
            } else if ($data['paymentmode'] == "BANK") {
                $transactionmode = 2;
                $accountrefid = 2;
            } else {
                $transactionmode = 0;
                $accountrefid = 2;
            }

            $description = $data['type'] . " - Invoice No : " . $invoiceProductDetails['salesBillDisplayNumber'];

            $sql = "INSERT INTO " . table_account_transaction . " (
                    " . account_transaction_date . ",
                    " . account_transaction_type . ",
                    " . account_transaction_ref_id . ",
                    " . account_transaction_amount . ",
                    " . account_transaction_mode . ",
                    " . account_transaction_created_by . ",
                    " . account_transaction_created_timestamp . ",
                    " . account_transaction_update_by . ",
                    " . account_transaction_update_timestamp . ",
                    " . account_transaction_description . ",
                    " . account_transaction_table_reference . ",
                    " . account_transaction_table_detail . ",
                    " . account_transaction_company_ref_id . ",
                    " . account_transaction_account_year_ref_id . "
                ) VALUES (
                    :" . account_transaction_date . ",
                    :" . account_transaction_type . ",
                    :" . account_transaction_ref_id . ",
                    :" . account_transaction_amount . ",
                    :" . account_transaction_mode . ",
                    :" . account_transaction_created_by . ",
                    NOW(),
                    :" . account_transaction_update_by . ",
                    NOW(),
                    :" . account_transaction_description . ",
                    :" . account_transaction_table_reference . ",
                    :" . account_transaction_table_detail . ",
                    :" . account_transaction_company_ref_id . ",
                    :" . account_transaction_account_year_ref_id . "
                )";

            $query = self::$db->prepare($sql);

            $parameter = array(
                ':' . account_transaction_date => $data['date'],
                ':' . account_transaction_type => 1,
                ':' . account_transaction_ref_id => $accountrefid,
                ':' . account_transaction_amount => $data['amount'],
                ':' . account_transaction_mode => $transactionmode,
                ':' . account_transaction_created_by => 1,
                ':' . account_transaction_update_by => 1,
                ':' . account_transaction_description => $description,
                ':' . account_transaction_table_reference => salesbilltable_reference_value,
                ':' . account_transaction_table_detail => self::$salesBillId,
                ':' . account_transaction_company_ref_id => self::$companyid,
                ':' . account_transaction_account_year_ref_id => self::$accountyearid
            );

            $query->execute($parameter);
        } catch (PDOException $ex) {

            $commit = 0;
            echo $ex->getMessage();
        } catch (Exception $ex) {

            $commit = 0;
            echo $ex->getMessage();
        }

        return $commit;
    }

    public static function addSaveCustomerTransaction($data, $invoiceProductDetails) {

        $commit = 1;

        try {

            $description = $data['type'] . " - Invoice No : " . $invoiceProductDetails['salesBillDisplayNumber'];

            $sql = "INSERT INTO " . table_customer_transaction . " (
                    " . customer_transaction_customer_ref_id . ",
                    " . customer_transaction_date . ",
                    " . customer_transaction_bill_type . ",
                    " . customer_transaction_type . ",
                    " . customer_transaction_description . ",
                    " . customer_transaction_amount . ",
                    " . customer_transaction_account_year_ref_id . ",
                    " . customer_transaction_company_ref_id . ",
                    " . customer_transaction_active_flag . ",
                    " . customer_transaction_created_by . ",
                    " . customer_transaction_createdTimestamp . ",
                    " . customer_transaction_updated_by . ",
                    " . customer_transaction_updatedTimestamp . ",
                    " . customer_transaction_table . ",
                    " . customer_transaction_table_detail . "
                ) VALUES (
                    :" . customer_transaction_customer_ref_id . ",
                    NOW(),
                    :" . customer_transaction_bill_type . ",
                    :" . customer_transaction_type . ",
                    :" . customer_transaction_description . ",
                    :" . customer_transaction_amount . ",
                    :" . customer_transaction_account_year_ref_id . ",
                    :" . customer_transaction_company_ref_id . ",
                    :" . customer_transaction_active_flag . ",
                    :" . customer_transaction_created_by . ",
                    NOW(),
                    :" . customer_transaction_updated_by . ",
                    NOW(),
                    :" . customer_transaction_table . ",
                    :" . customer_transaction_table_detail . "
                )";

            $query = self::$db->prepare($sql);

            $parameter = array(
                ':' . customer_transaction_customer_ref_id => self::$customerId,
                ':' . customer_transaction_bill_type => 3,
                ':' . customer_transaction_type => 1,
                ':' . customer_transaction_description => $description,
                ':' . customer_transaction_amount => $data['amount'],
                ':' . customer_transaction_account_year_ref_id => self::$accountyearid,
                ':' . customer_transaction_company_ref_id => self::$companyid,
                ':' . customer_transaction_active_flag => 1,
                ':' . customer_transaction_created_by => 1,
                ':' . customer_transaction_updated_by => 1,
                ':' . customer_transaction_table => salesbilltable_reference_value,
                ':' . customer_transaction_table_detail => self::$salesBillId
            );

            $query->execute($parameter);
        } catch (PDOException $ex) {

            $commit = 0;
            echo $ex->getMessage();
        } catch (Exception $ex) {

            $commit = 0;
            echo $ex->getMessage();
        }

        return $commit;
    }

    public static function addSaveInvoiceBillItem($data, $invoiceProductDetails) {

        $commit = 1;

        try {
            // Step 1 -> Product Details
            $productId = $invoiceProductDetails['productId'];
            $commodityRefId = $invoiceProductDetails['commodityRefId'];
            $commodityHSNCodeRef = $invoiceProductDetails['commodityHSNCodeRef'];

            // Step 2 -> GST Details
            $cgstRate = floatval($invoiceProductDetails['cgstRate']);
            $sgstRate = floatval($invoiceProductDetails['sgstRate']);
            $igstRate = floatval($invoiceProductDetails['igstRate']);

            // Step 3 -> Amount Calculation
            $totalAmount = floatval($data['amount']);
            $totalGstRate = $cgstRate + $sgstRate + $igstRate;

            if ($totalGstRate > 0) {
                $taxableValue = $totalAmount / (1 + ($totalGstRate / 100));
            } else {
                $taxableValue = $totalAmount;
            }

            // Step 4 -> GST Amount
            $cgstTotal = $taxableValue * ($cgstRate / 100);
            $sgstTotal = $taxableValue * ($sgstRate / 100);
            $igstTotal = $taxableValue * ($igstRate / 100);

            // Round
            $taxableValue = round($taxableValue, 2);
            $cgstTotal = round($cgstTotal, 2);
            $sgstTotal = round($sgstTotal, 2);
            $igstTotal = round($igstTotal, 2);

            // Total including tax
            $totalWithTax = round($taxableValue + $cgstTotal + $sgstTotal + $igstTotal, 2);

            $sql = "INSERT INTO " . table_sales_bill_item . " (
                    " . salesbillitem_sales_bill_ref_id . ",
                    " . salesbillitem_item_ref_id . ",
                    " . salesbillitem_sales_bill_date . ",
                    " . salesbillitem_unit_rate . ",
                    " . salesbillitem_Discount . ",
                    " . salesbillitem_quantity . ",
                    " . salesbillitem_total . ",
                    " . salesbillitem_cgst_rate . ",
                    " . salesbillitem_cgst_total . ",
                    " . salesbillitem_sgst_rate . ",
                    " . salesbillitem_sgst_total . ",
                    " . salesbillitem_igst_rate . ",
                    " . salesbillitem_igst_total . ",
                    " . salesbillitem_hsn_code_ref_id . ",
                    " . salesbillitem_sales_customer_ref_id . ",
                    " . salesbillitem_company_ref_id . ",
                    " . salesbillitem_account_year_ref_id . ",
                    " . salesbillitem_sales_bill_type . ",
                    " . salesbillitem_commodity_ref_id . ",
                    " . salesbillitem_unitrate_wittax . ",
                    " . salesbillitem_total_withtax . "
                ) VALUES (
                    :" . salesbillitem_sales_bill_ref_id . ",
                    :" . salesbillitem_item_ref_id . ",
                    :" . salesbillitem_sales_bill_date . ",
                    :" . salesbillitem_unit_rate . ",
                    0,
                    1,
                    :" . salesbillitem_total . ",
                    :" . salesbillitem_cgst_rate . ",
                    :" . salesbillitem_cgst_total . ",
                    :" . salesbillitem_sgst_rate . ",
                    :" . salesbillitem_sgst_total . ",
                    :" . salesbillitem_igst_rate . ",
                    :" . salesbillitem_igst_total . ",
                    :" . salesbillitem_hsn_code_ref_id . ",
                    :" . salesbillitem_sales_customer_ref_id . ",
                    :" . salesbillitem_company_ref_id . ",
                    :" . salesbillitem_account_year_ref_id . ",
                    :" . salesbillitem_sales_bill_type . ",
                    :" . salesbillitem_commodity_ref_id . ",
                    :" . salesbillitem_unitrate_wittax . ",
                    :" . salesbillitem_total_withtax . "
                )";

            $query = self::$db->prepare($sql);

            $parameter = array(
                ':' . salesbillitem_sales_bill_ref_id => self::$salesBillId,
                ':' . salesbillitem_item_ref_id => $productId,
                ':' . salesbillitem_sales_bill_date => $data['date'],
                ':' . salesbillitem_unit_rate => $taxableValue,
                ':' . salesbillitem_total => $taxableValue,
                ':' . salesbillitem_cgst_rate => $cgstRate,
                ':' . salesbillitem_cgst_total => $cgstTotal,
                ':' . salesbillitem_sgst_rate => $sgstRate,
                ':' . salesbillitem_sgst_total => $sgstTotal,
                ':' . salesbillitem_igst_rate => $igstRate,
                ':' . salesbillitem_igst_total => $igstTotal,
                ':' . salesbillitem_hsn_code_ref_id => $commodityHSNCodeRef,
                ':' . salesbillitem_sales_customer_ref_id => 0,
                ':' . salesbillitem_company_ref_id => self::$companyid,
                ':' . salesbillitem_account_year_ref_id => self::$accountyearid,
                ':' . salesbillitem_sales_bill_type => 3,
                ':' . salesbillitem_commodity_ref_id => $commodityRefId,
                ':' . salesbillitem_unitrate_wittax => $totalAmount,
                ':' . salesbillitem_total_withtax => $totalWithTax
            );

            $query->execute($parameter);
        } catch (PDOException $ex) {
            $commit = 0;
            echo $ex->getMessage();
        } catch (Exception $ex) {
            $commit = 0;
            echo $ex->getMessage();
        }
        return $commit;
    }

    public static function getInvoiceProductDetails($data) {
        try {
            // Step 1 Get Productid , Commodityid
            $sql = "SELECT
                    p." . items_item_id . " AS productId,
                    p." . items_commodity_id . " AS commodityRefId
                FROM " . table_items . " p
                WHERE p." . items_name . " = :type
                AND p." . items_active_flag . " = 1
                LIMIT 1";
            $query = self::$db->prepare($sql);
            $parameter = array(
                ':type' => $data['type']
            );
            $query->execute($parameter);
            $product = $query->fetch(PDO::FETCH_OBJ);
            if (!$product) {
                return 0;
            }
            $productId = $product->productId;
            $commodityRefId = $product->commodityRefId;

            // Step 2 -> Get Commodity HSN Reference
            $sql = "SELECT " . commodity_HSNcode_ref . " AS commodityHSNCodeRef
                FROM " . table_commodity . "
                WHERE " . commodity_id . " = :commodityRefId
                LIMIT 1";
            $query = self::$db->prepare($sql);
            $parameter = array(
                ':commodityRefId' => $commodityRefId
            );
            $query->execute($parameter);
            $commodity = $query->fetch(PDO::FETCH_OBJ);
            if (!$commodity) {
                return 0;
            }
            $commodityHSNCodeRef = $commodity->commodityHSNCodeRef;

            // Step 3 -> Get GST HSN Details
            $sql = "SELECT
                    " . gsthsncode_cgst_rate . " AS cgstRate,
                    " . gsthsncode_sgst_rate . " AS sgstRate,
                    " . gsthsncode_igst_rate . " AS igstRate
                FROM " . table_gst_HSNCode . "
                WHERE " . gsthsncode_hsn_code . " = :commodityHSNCodeRef
                LIMIT 1";
            $query = self::$db->prepare($sql);
            $parameter = array(
                ':commodityHSNCodeRef' => $commodityHSNCodeRef
            );
            $query->execute($parameter);
            $gstHsn = $query->fetch(PDO::FETCH_OBJ);
            if (!$gstHsn) {
                return 0;
            }
            $cgstRate = $gstHsn->cgstRate;
            $sgstRate = $gstHsn->sgstRate;
            $igstRate = $gstHsn->igstRate;


            // Step 4 -> Get Sales Bill Prefix
            $sql = "SELECT " . sales_prefix_value . " AS salesBillPrefixValue
                FROM " . table_sales_bill_prefix . "
                WHERE " . salesbillprefixvalue_type . " = :type
                AND " . sales_prefix_company_id . " = :companyRefId
                AND " . sales_prefix_account_id . " = :accountyearRefId
                LIMIT 1";
            $query = self::$db->prepare($sql);
            $parameter = array(
                ':type' => $data['type'],
                ':companyRefId' => self::$companyid,
                ':accountyearRefId' => self::$accountyearid
            );
            $query->execute($parameter);
            $prefix = $query->fetch(PDO::FETCH_OBJ);
            if (!$prefix) {
                return 0;
            }
            $salesBillPrefixValue = $prefix->salesBillPrefixValue;

            // Step 5 -> Get Last Bill Number
            $sql = "SELECT MAX(" . salesbill_sales_bill_number . ") AS billCount
                FROM " . table_sales_bill . "
                WHERE " . salesbill_type . " = :type
                AND " . salesbill_company_ref_id . " = :companyRefId
                AND " . salesbill_account_year_ref_id . " = :accountYearId";
            $query = self::$db->prepare($sql);
            $parameter = array(
                ':type' => $data['type'],
                ':companyRefId' => self::$companyid,
                ':accountYearId' => self::$accountyearid
            );
            $query->execute($parameter);
            $billCount = $query->fetch(PDO::FETCH_OBJ);
            $lastBillNumber = intval($billCount->billCount);
            $salesBillNumber = $lastBillNumber + 1;

            // Step 6 -> Create Bill Number
            $salesBillDisplayNumber = $salesBillPrefixValue . $salesBillNumber;

            // Step 7 -> Amount
            $totalAmount = floatval($data['amount']);

            // Step 8 -> Calculate GST
            // Assuming amount is GST inclusive
            $totalGstRate = $cgstRate + $sgstRate;
            if ($totalGstRate > 0) {
                $runningTotal = $totalAmount / (1 + ($totalGstRate / 100));
            } else {
                $runningTotal = $totalAmount;
            }

            // Step 9 -> Calculate CGST / SGST / IGST
            $cgstTotal = $runningTotal * ($cgstRate / 100);
            $sgstTotal = $runningTotal * ($sgstRate / 100);
            $igstTotal = 0;


            // Step 10 -> Round Values
            $runningTotal = round($runningTotal, 2);
            $cgstTotal = round($cgstTotal, 2);
            $sgstTotal = round($sgstTotal, 2);
            $igstTotal = round($igstTotal, 2);

            // Step 11 -> Final Total
            $salesBillTotal = round($runningTotal + $cgstTotal + $sgstTotal + $igstTotal, 2);

            // Step 7 -> Return All Details
            return array(
                'productId' => $productId,
                'commodityRefId' => $commodityRefId,
                'commodityHSNCodeRef' => $commodityHSNCodeRef,
                'cgstRate' => $cgstRate,
                'sgstRate' => $sgstRate,
                'igstRate' => $igstRate,
                'salesBillPrefixValue' => $salesBillPrefixValue,
                'salesBillNumber' => $salesBillNumber,
                'salesBillDisplayNumber' => $salesBillDisplayNumber,
                'totalAmount' => $totalAmount,
                'runningTotal' => $runningTotal,
                'cgstTotal' => $cgstTotal,
                'sgstTotal' => $sgstTotal,
                'igstTotal' => $igstTotal,
                'salesBillTotal' => $salesBillTotal,
            );
        } catch (PDOException $ex) {

            echo $ex->getMessage();
            return 0;
        } catch (Exception $ex) {

            echo $ex->getMessage();
            return 0;
        }
    }

    public static function addSaveInvoiceBill($data, $invoiceProductDetails) {

        $commit = 1;
        try {

            // Step 1 -> Product Details
            $productId = $invoiceProductDetails['productId'];
            $commodityRefId = $invoiceProductDetails['commodityRefId'];
            $commodityHSNCodeRef = $invoiceProductDetails['commodityHSNCodeRef'];

            $cgstRate = floatval($invoiceProductDetails['cgstRate']);
            $sgstRate = floatval($invoiceProductDetails['sgstRate']);
            $igstRate = floatval($invoiceProductDetails['igstRate']);

            $salesBillNumber = $invoiceProductDetails['salesBillNumber'];
            $salesBillDisplayNumber = $invoiceProductDetails['salesBillDisplayNumber'];

            $totalAmount = $invoiceProductDetails['totalAmount'];
            $runningTotal = $invoiceProductDetails['runningTotal'];

            $cgstTotal = $invoiceProductDetails['cgstTotal'];
            $sgstTotal = $invoiceProductDetails['sgstTotal'];
            $igstTotal = $invoiceProductDetails['igstTotal'];

            $salesBillTotal = $invoiceProductDetails['salesBillTotal'];

            // Step 7 -> Insert Sales Bill
            $sql = "INSERT INTO " . table_sales_bill . " (
                        " . salesbill_sales_bill_number . ",
                        " . salesbill_sales_bill_display_number . ",
                        " . salesbill_sales_bill_date . ",
                        " . salesbill_customer_id . ",
                        " . salesbill_cgst_total . ",
                        " . salesbill_sgst_total . ",
                        " . salesbill_igst_total . ",
                        " . salesbill_running_total . ",
                        " . salesbill_round_off . ",
                        " . salesbill_sales_bill_total . ",
                        " . salesbill_company_ref_id . ",
                        " . salesbill_account_year_ref_id . ",
                        " . salesbill_created_by . ",
                        " . salesbill_created_timetamp . ",
                        " . salesbill_sales_bill_type . ",
                        " . salesbill_sales_bill_stage . ",
                        " . salesbill_sales_bill_lock . ",
                        " . salesbill_gst_type . ",
                        " . salesbill_total_discount . ",
                        " . salesbill_product_discount . ",
                        " . salesbill_address_id . ",
                        " . salesbill_vat_cst_flag . ",
                        " . salesbill_ewayBillNo . ",
                        " . salesbill_lrNumber . ",
                        " . salesbill_lrDate . ",
                        " . salesbill_marksonpackage . ",
                        " . salesbill_packing_charge . ",
                        " . salesbill_type . ",
                        " . salesbill_less . "
                    ) VALUES (
                        :" . salesbill_sales_bill_number . ",
                        :" . salesbill_sales_bill_display_number . ",
                        :" . salesbill_sales_bill_date . ",
                        :" . salesbill_customer_id . ",
                        :" . salesbill_cgst_total . ",
                        :" . salesbill_sgst_total . ",
                        :" . salesbill_igst_total . ",
                        :" . salesbill_running_total . ",
                        0,
                        :" . salesbill_sales_bill_total . ",
                        :" . salesbill_company_ref_id . ",
                        :" . salesbill_account_year_ref_id . ",
                        :" . salesbill_created_by . ",
                        NOW(),
                        :" . salesbill_sales_bill_type . ",
                        :" . salesbill_sales_bill_stage . ",
                        :" . salesbill_sales_bill_lock . ",
                        1,
                        0,
                        0,
                        0,
                        0,
                        '',
                        '',
                        NULL,
                        '',
                        0,
                        :" . salesbill_type . ",
                        0
                    )";
            $query = self::$db->prepare($sql);
            $parameter = array(
                ':' . salesbill_sales_bill_date => $data['date'],
                ':' . salesbill_sales_bill_number => $salesBillNumber,
                ':' . salesbill_sales_bill_display_number => $salesBillDisplayNumber,
                ':' . salesbill_customer_id => self::$customerId,
                ':' . salesbill_cgst_total => $cgstTotal,
                ':' . salesbill_sgst_total => $sgstTotal,
                ':' . salesbill_igst_total => $igstTotal,
                ':' . salesbill_running_total => $runningTotal,
                ':' . salesbill_sales_bill_total => $salesBillTotal,
                ':' . salesbill_company_ref_id => self::$companyid,
                ':' . salesbill_account_year_ref_id => self::$accountyearid,
                ':' . salesbill_created_by => 1,
                ':' . salesbill_sales_bill_type => 1,
                ':' . salesbill_sales_bill_stage => 1,
                ':' . salesbill_type => $data['type'],
                ':' . salesbill_sales_bill_lock => 0
            );


            $query->execute($parameter);

            self::$salesBillId = self::$db->lastInsertId();
        } catch (PDOException $ex) {

            $commit = 0;
            echo $ex->getMessage();
        } catch (Exception $ex) {

            $commit = 0;
            echo $ex->getMessage();
        }

        return $commit;
    }

    public static function createCustomer($data) {
        try {

            $sql = "INSERT INTO " . table_customer . " (
                        " . customer_name . ",
                        " . customer_party_gst_type . ",
                        " . customer_type . ",
                        " . customer_company_ref_id . ",
                        " . customer_created_by . ",
                        " . customer_created_time_stamp . ",
                        " . customer_active_flag . "
                    ) VALUES (
                        :" . customer_name . ",
                        :" . customer_party_gst_type . ",
                        :" . customer_type . ",
                        :" . customer_company_ref_id . ",
                        :" . customer_created_by . ",
                        NOW(),
                        :" . customer_active_flag . "
                    )";

            $query = self::$db->prepare($sql);

            $parameter = array(
                ':' . customer_name => $data['mobileNo'],
                ':' . customer_party_gst_type => 1,
                ':' . customer_type => 1,
                ':' . customer_company_ref_id => self::$companyid,
                ':' . customer_created_by => 1,
                ':' . customer_active_flag => 1
            );

            $query->execute($parameter);

            return self::$db->lastInsertId();
        } catch (PDOException $ex) {

            echo $ex->getMessage();
            return 0;
        } catch (Exception $ex) {
            echo $ex->getMessage();
            return 0;
        }
    }

    public static function createCustomerAddress($customerId, $data) {

        try {


            $sql = "INSERT INTO " . table_customer_address . " (
                    " . customeraddress_customer_ref_id . ",
                    " . customeraddress_mobile . ",
                    " . customeraddress_address_type . ",
                    " . customeraddress_active_flag . ",
                    " . customeraddress_created_by . ",
                    " . customeraddress_created_timestamp . ",
                    " . customeraddress_updated_timestamp . "
                ) VALUES (
                    :customerRefId,
                    :mobile,
                    :addressType,
                    :activeFlag,
                    :createdBy,
                    NOW(),
                    NOW()
                )";

            $query = self::$db->prepare($sql);

            $parameter = array(
                ':customerRefId' => $customerId,
                ':mobile' => $data['mobileNo'],
                ':addressType' => primaryAddress,
                ':activeFlag' => 1,
                ':createdBy' => 1
            );

            $query->execute($parameter);

            return 1;
        } catch (PDOException $ex) {

            echo $ex->getMessage();
            return 0;
        } catch (Exception $ex) {

            echo $ex->getMessage();
            return 0;
        }
    }

    public static function createCustomerOpeningBalance($customerId) {

        try {


            $sql = "INSERT INTO " . table_customer_opening_balance . " (
                    " . customer_opening_customerid . ",
                    " . customer_opening_balance . ",
                    " . customer_closing_balance . ",
                    " . customer_trial_balance . ",
                    " . customer_open_company_ref_id . ",
                    " . customer_open_account_year_id . "
                ) VALUES (
                    :customerRefId,
                    :openingBalance,
                    :closingBalance,
                    :trialBalance,
                    :companyRefId,
                    :accountYearRefId
                )";

            $query = self::$db->prepare($sql);

            $parameter = array(
                ':customerRefId' => $customerId,
                ':openingBalance' => 0,
                ':closingBalance' => 0,
                ':trialBalance' => 0,
                ':companyRefId' => self::$companyid,
                ':accountYearRefId' => self::$accountyearid
            );

            $query->execute($parameter);

            return 1;
        } catch (PDOException $ex) {

            echo $ex->getMessage();
            return 0;
        } catch (Exception $ex) {

            echo $ex->getMessage();
            return 0;
        }
    }

    public static function getCustomerByMobileNo($mobileNo) {

        try {

            $sql = "SELECT c." . customer_id . "
                    FROM " . table_customer . " c
                    INNER JOIN " . table_customer_address . " ca
                        ON ca." . customeraddress_customer_ref_id . " = c." . customer_id . "
                    WHERE ca." . customeraddress_mobile . " = :mobileNo
                    AND ca." . customeraddress_active_flag . " = 1
                    AND c." . customer_active_flag . " = 1
                    AND c." . customer_company_ref_id . " = :companyRefId
                    LIMIT 1";

            $query = self::$db->prepare($sql);

            $parameter = array(
                ':mobileNo' => $mobileNo,
                ':companyRefId' => self::$companyid
            );

            $query->execute($parameter);

            $result = $query->fetch(PDO::FETCH_OBJ);

            if ($result) {
                return $result->customerID;
            }

            return 0;
        } catch (PDOException $ex) {

            echo $ex->getMessage();
            return 0;
        } catch (Exception $ex) {

            echo $ex->getMessage();
            return 0;
        }
    }

    public static function getOrCreateCustomer($data) {

        try {

            // Step 1: Check existing customer using mobile number
            $customerId = self::getCustomerByMobileNo($data['mobileNo']);

            // Customer already exists
            if ($customerId > 0) {
                return $customerId;
            }

            // Step 2: Customer does not exist
            $customerId = self::createCustomer($data);

            if ($customerId == 0) {
                return 0;
            }

            // Step 3: Create customer address
            $commit = self::createCustomerAddress($customerId, $data);

            if ($commit != 1) {
                return 0;
            }

            // Step 4: Create opening balance
            $commit = self::createCustomerOpeningBalance($customerId);

            if ($commit != 1) {
                return 0;
            }

            return $customerId;
        } catch (PDOException $ex) {

            echo $ex->getMessage();
            return 0;
        } catch (Exception $ex) {

            echo $ex->getMessage();
            return 0;
        }
    }

    public static function updateinvoicerawdatas($invoicerawdatalastinsertedid) {

        $commit = 1;

        try {

            $sql = "UPDATE " . table_invoicerawdatas . "
                SET " . invoicerawdata_status . " = :status,
                    " . invoicerawdata_updatedtimestamp . " = NOW()
                WHERE " . invoicerawdata_id . " = :id";

            $query = self::$db->prepare($sql);

            $parameter = array(
                ':status' => 'COMPLETED',
                ':id' => $invoicerawdatalastinsertedid
            );

            $query->execute($parameter);
        } catch (PDOException $ex) {

            $commit = 0;
            echo $ex->getMessage();
        } catch (Exception $ex) {

            $commit = 0;
            echo $ex->getMessage();
        }

        return $commit;
    }

    public static function saveinvoicerawdatas($data) {
        $commit = 1;
        try {
            $sql = "INSERT INTO " . table_invoicerawdatas . " (
                        " . invoicerawdata_rawdata . ",
                        " . invoicerawdata_amount . ",
                        " . invoicerawdata_status . ",
                        " . invoicerawdata_cronreruncount . ",
                        " . invoicerawdata_companyrefid . ",
                        " . invoicerawdata_accountyearrefid . ",
                        " . invoicerawdata_createdtimestamp . ",
                        " . invoicerawdata_updatedtimestamp . "
                    ) VALUES (
                        :" . invoicerawdata_rawdata . ",
                        :" . invoicerawdata_amount . ",
                        :" . invoicerawdata_status . ",
                        :" . invoicerawdata_cronreruncount . ",
                        :" . invoicerawdata_companyrefid . ",
                        :" . invoicerawdata_accountyearrefid . ",
                        NOW(),
                        NOW()
                    )";

            $query = self::$db->prepare($sql);

            $parameter = array(
                ':' . invoicerawdata_rawdata => json_encode($data),
                ':' . invoicerawdata_amount => $data['amount'],
                ':' . invoicerawdata_status => 'PENDING',
                ':' . invoicerawdata_cronreruncount => 0,
                ':' . invoicerawdata_companyrefid => self::$companyid,
                ':' . invoicerawdata_accountyearrefid => self::$accountyearid
            );

            $query->execute($parameter);
        } catch (PDOException $ex) {

            $commit = 0;
            echo $ex->getMessage();
        } catch (Exception $ex) {

            $commit = 0;
            echo $ex->getMessage();
        }

        return $commit;
    }

    public static function saveinvoiceEntry($data) {

        self::$db->beginTransaction();

        // Step 1 - Get AccountYear & Company
        $companyAccountYear = self::getCompanyAndAccountYearId($data);

        if ($companyAccountYear == 0) {
            return 0;
        }

        self::$companyid = $companyAccountYear['companyId'];
        self::$accountyearid = $companyAccountYear['accountYearId'];


        //  Step 2 -> Insert raw datas in Invoice table
        $commit = self::saveinvoicerawdatas($data);
        $invoicerawdatalastinsertedid = self::$db->lastInsertId();


        // Step 3 -> Get or Create Customer
        $customerId = self::getOrCreateCustomer($data);
        self::$customerId = $customerId;
        if ($customerId == 0) {
            self::$db->rollback();
            return 0;
        }

        // get Herlper Data for ProductDetails
        $invoiceProductDetails = self::getInvoiceProductDetails($data);
        if ($invoiceProductDetails == 0) {
            return 0;
        }

        // Step 4 -> Add the Invoice entry
        $commit = self::addSaveInvoiceBill($data, $invoiceProductDetails);
        self::$salesBillId = self::$db->lastInsertId();
        if ($commit == 0) {
            self::$db->rollback();
            return 0;
        }

        // Step 5 -> Add the Invoice entry items
        $commit = self::addSaveInvoiceBillItem($data, $invoiceProductDetails);
        if ($commit == 0) {
            self::$db->rollback();
            return 0;
        }

        // Step 6 -> save the Customer transaction
        $commit = self::addSaveCustomerTransaction($data, $invoiceProductDetails);
        if ($commit == 0) {
            self::$db->rollback();
            return 0;
        }

        // Step 7 -> save the Account transaction
        $commit = self::addSaveAccountTransaction($data, $invoiceProductDetails);
        if ($commit == 0) {
            self::$db->rollback();
            return 0;
        }

        // Step 8 -> save the Day transaction
        $commit = self::addSaveDayTransaction($data, $invoiceProductDetails);
        if ($commit == 0) {
            self::$db->rollback();
            return 0;
        }

        // Step 9 -> Update the Invoice Status
        if ($commit == 1) {
            $commit = self::updateinvoicerawdatas($invoicerawdatalastinsertedid);
        }


        if ($commit == 1) {
            self::$db->commit();
        } else {
            self::$db->Rollback();
        }

        return json_encode(array(
            "success" => true,
            "message" => "Invoice raw data saved successfully",
            "data" => array(
                "invoiceRawDataId" => $invoicerawdatalastinsertedid,
                "companyId" => self::$companyid,
                "accountYearId" => self::$accountyearid,
                "CustomerId" => $customerId,
                "status" => "COMPLETED",
                "commit" => $commit,
            )
        ));
    }

