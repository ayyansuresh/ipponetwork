<?php

class gdc extends Controller {

    public function index() {
        
    }

    public function loadGDC() {
        self::loadBlock('item/itemBlock');
        self::loadBlock('gdc/gdcBlock');
        self::loadDesign('gdc/gdcForm');
    }
    public function loadCloseGDC() {
        self::loadBlock('gdc/gdcBlock');
        self::loadDesign('gdc/gdcClose');
    }
    public function loadCloseGDCDetails() {
        self::loadDesign('gdc/closeGDCDetails');
    }
    public function loadUpdateGDC() {
        self::loadBlock('gdc/gdcBlock');
        self::loadDesign('gdc/updateGDC');
    }
    public function loadGDCUpdateDetails() {
        self::loadBlock('gdc/gdcBlock');
        self::loadBlock('item/itemBlock');
        self::loadDesign('gdc/updateGDCDetails');
    }
    public function addNewGdc() {
        self::loadBlock('gdc/gdcBlock');
        $addFlag = gdcBlock::saveNewGdc();
        if ($addFlag == 1) {
            self::loadDesign('gdc/gdcAddSuccess');
        } else {
            self::loadDesign('sales/addNewSalesBillFail');
            echo 'fail';
        }
    }
    
    public function updateGdcDetails() {
        self::loadBlock('gdc/gdcBlock');
        $addFlag = gdcBlock::updateGdcDetails();
        if ($addFlag == 1) {
            self::loadDesign('gdc/gdcUpdateSuccess');
        } else {
            self::loadDesign('sales/updateSalesBillFail');
            echo 'fail';
        }
    }
    public function loadGDCCloseDetails() {
        self::loadBlock('gdc/gdcBlock');
        self::loadBlock('item/itemBlock');
        self::loadDesign('gdc/closeGDCDetails');
    }
    public function closeGdcDetails() {
        self::loadBlock('gdc/gdcBlock');
        $addFlag = gdcBlock::closeGdcDetails();
        if ($addFlag == 1) {
            self::loadDesign('gdc/gdcUpdateSuccess');
        } else {
            self::loadDesign('sales/updateSalesBillFail');
            echo 'fail';
        }
    }
    public function loadGDCReports() {
        self::loadBlock('gdc/gdcBlock');
        self::loadBlock('item/itemBlock');
        self::loadDesign('gdc/GDCReports');
    }
    public function getItemNameByCompanyJson() {
        self::loadBlock('gdc/gdcBlock');
        $itemarray = gdcBlock::getItemNameByCompanyJson();
        $stack = array(
            "item" => $itemarray
        );
        echo json_encode($stack);
    }
    public function loadGdcReportsDetails() {
        self::loadBlock('gdc/gdcBlock');
        self::loadBlock('item/itemBlock');
        self::loadDesign('gdc/GDCReportsGrid');
    }
    public function loadGdcReportPdf() {
        self::loadBlock('gdc/gdcBlock');
        gdcBlock::loadGdcReportPdf();
    }
    public function printGdcReportPdf() {
        self::loadBlock('gdc/gdcBlock');
        self::loadDesign('gdc/printGdcReportDetailPdf');
    }
    public function reportHeaderGdc() {
        self::loadBlock('gdc/gdcBlock');
        self::loadBlock('sales/salesInvoiceBlock');
        self::loadBlock('item/itemBlock');
        self::loadDesign('reports/header/reportHeaderGdcDetails');
    }
    
}
