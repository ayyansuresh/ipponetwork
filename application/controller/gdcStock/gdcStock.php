<?php

class gdcStock extends Controller {

    public function index() {
        
    }

    public function loadGDCStockEntry() {
        self::loadBlock('item/itemBlock');
        self::loadBlock('gdc/gdcBlock');
        self::loadDesign('gdcStock/gdcForm');
    }
    public function addNewGdc() {
        self::loadBlock('gdcStock/gdcStockBlock');
        $addFlag = gdcStockBlock::saveNewGdc();
        if ($addFlag == 1) {
            self::loadDesign('gdcStock/gdcStockAddSuccess');
        } else {
            self::loadDesign('gdcStock/gdcStockAddFail');
            echo 'fail';
        }
    }
    
    public function updateGdcDetails() {
        self::loadBlock('gdcStock/gdcStockBlock');
        $addFlag = gdcStockBlock::updateGdcStockDetails();
        if ($addFlag == 1) {
            self::loadDesign('gdcStock/gdcStockUpdateSuccess');
        } else {
            self::loadDesign('sales/updateSalesBillFail');
            echo 'fail';
        }
    }
    
    public function loadUpdateGDCStock() {
        self::loadBlock('gdcStock/gdcStockBlock');
        self::loadDesign('gdcStock/updateGDCStock');
    }
    public function loadGDCStockUpdateDetails() {
        self::loadBlock('gdcStock/gdcStockBlock');
        self::loadBlock('item/itemBlock');
        self::loadDesign('gdcStock/updateGDCStockDetails');
    }
    public function loadCloseGDCStock() {
        self::loadBlock('gdcStock/gdcStockBlock');
        self::loadDesign('gdcStock/gdcStockClose');
    }
    public function loadGDCStockCloseDetails() {
        self::loadBlock('gdcStock/gdcStockBlock');
        self::loadBlock('item/itemBlock');
        self::loadDesign('gdcStock/closeGDCStockDetails');
    }
    public function closeGdcStockDetails() {
        self::loadBlock('gdcStock/gdcStockBlock');
        $addFlag = gdcStockBlock::closeGdcStockDetails();
        if ($addFlag == 1) {
            self::loadDesign('gdcStock/gdcCloseSuccess');
        } else {
            self::loadDesign('sales/updateSalesBillFail');
            echo 'fail';
        }
    }
    public function loadGDCStockReports() {
        self::loadBlock('gdcStock/gdcStockBlock');
        self::loadBlock('item/itemBlock');
        self::loadDesign('gdcStock/GDCStockReports');
    }
    public function loadGdcStockReportsDetails() {
        self::loadBlock('gdcStock/gdcStockBlock');
        self::loadBlock('item/itemBlock');
        self::loadDesign('gdcStock/GDCStockReportsGrid');
    }
    public function loadGdcStockReportPdf() {
        self::loadBlock('gdcStock/gdcStockBlock');
        gdcStockBlock::loadGdcStockReportPdf();
    }
    public function printGdcStockReportPdf() {
        self::loadBlock('gdcStock/gdcStockBlock');
        self::loadDesign('gdcStock/printGdcStockReportDetailPdf');
    }
    public function reportHeaderGdc() {
        self::loadBlock('gdcStock/gdcStockBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadDesign('reports/header/reportHeaderGdcStockDetails');
    }
}
