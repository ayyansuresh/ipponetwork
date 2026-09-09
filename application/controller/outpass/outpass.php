<?php

class outpass extends Controller {

    public function index() {
        
    }

    public function outpassEntry() {
        self::loadBlock('outpass/outpassBlock');
        self::loadDesign('outpass/newOutpassEntry');
    }
    public function outpassUpdate() {
        self::loadBlock('outpass/outpassBlock');
        self::loadDesign('outpass/outpassUpdate');
    }
    public function loadIssueDetails() {
        self::loadBlock('outpass/outpassBlock');
        self::loadDesign('outpass/outpassUpdateDetails');
    }
    public function vendorOutpassEntry() {
        self::loadDesign('outpass/vendorOutpassEntry');
    }
    public function vendorOutpassUpdate() {
        self::loadDesign('outpass/vendorOutpassUpdate');
    }
    public function loadVendorOutpassDetails() {
        self::loadDesign('outpass/vendorOutpassUpdateDetails');
    }
    public function receiveEntry() {
        self::loadBlock('outpass/outpassBlock');
        self::loadDesign('outpass/newReceiveEntry');
    }
    public function receiveUpdate() {
        self::loadBlock('outpass/outpassBlock');
        self::loadDesign('outpass/receiveUpdate');
    }
    public function receiveUpdateDetails() {
        self::loadBlock('outpass/outpassBlock');
        self::loadDesign('outpass/receiveUpdateDetails');
    }
    public function makeIssueInvoice() {
        self::loadBlock('outpass/outpassBlock');
        $addFlag = outpassBlock::saveIssueInvoice();
        /*if ($addFlag == 1) {
            echo "true";
            self::loadDesign('outpass/addnewissuesuccess');
        } else {
            self::loadDesign('outpass/addnewissuefail');
            echo 'fail';
        }*/
    }
    public function loadPartyByType() {
        self::loadBlock('outpass/outpassBlock');
        outpassBlock::loadPartyByType();
    }
    public function generateIssuePdf() {
        self::loadBlock('outpass/outpassBlock');
        outpassBlock::generateIssuePdf();
    }
    public function printIssuePdf() {
        self::loadBlock('outpass/outpassBlock');
        self::loadDesign('outpass/invoiceissuepdf');
    }
    public function updateIssueInvoice() {
        self::loadBlock('outpass/outpassBlock');
        $addFlag = outpassBlock::updateIssueInvoice();
        if ($addFlag == 1) {
            self::loadDesign('outpass/addupdateissuesuccess');
        } else {
            self::loadDesign('outpass/addupdateissuefail');
            echo 'fail';
        }
    }
    public function loadReceivePartyByType() {
        self::loadBlock('outpass/outpassBlock');
        outpassBlock::loadReceivePartyByType();
    }
    public function loadReceiveJobnoByParty() {
        self::loadBlock('outpass/outpassBlock');
        outpassBlock::loadReceiveJobnoByParty();
    }
    public function loadProcessTypeDesign() {
        self::loadBlock('outpass/outpassBlock');
        self::loadDesign('outpass/loadprocesstypedesign');
    }
    public function loadByJobno() {
        self::loadBlock('outpass/outpassBlock');
         outpassBlock::loadByJobno();
    }
    public function makeReceiveInvoicePrint(){
        self::loadBlock('outpass/outpassBlock');
        $addFlag = outpassBlock::saveReceiveInvoice();
        if ($addFlag != "") {
           self::loadDesign('outpass/addnewreceivesuccess');
        } else {
            self::loadDesign('outpass/addnewreceivefail');
            //echo 'fail';
        }
    }
    public function loadReceiveDetails() {
        self::loadBlock('outpass/outpassBlock');
        self::loadDesign('outpass/receiveupdatedetails');
    }
    public function loadEditReceivePartyByType() {
        self::loadBlock('outpass/outpassBlock');
        outpassBlock::loadEditReceivePartyByType();
    }
    public function loadEditReceiveJobnoByParty() {
        self::loadBlock('outpass/outpassBlock');
        outpassBlock::loadEditReceiveJobnoByParty();
    }
    public function loadEditByJobno() {
        self::loadBlock('outpass/outpassBlock');
         outpassBlock::loadEditByJobno();
    }
    public function loadEditProcessTypeDesign() {
        self::loadBlock('outpass/outpassBlock');
        self::loadDesign('outpass/loadeditprocesstypedesign');
    }
    public function loadHiddenFields() {
        self::loadBlock('outpass/outpassBlock');
        self::loadDesign('outpass/loadHiddenFields');
    }
    public function loadReceiveHiddenFields() {
        self::loadBlock('outpass/outpassBlock');
        self::loadDesign('outpass/loadReceiveHiddenFields');
    }
    public function generateReceivePdf() {
        self::loadBlock('outpass/outpassBlock');
        outpassBlock::generateReceivePdf();
    }
    public function printReceivePdf() {
        self::loadBlock('outpass/outpassBlock');
        self::loadDesign('outpass/invoicereceivepdf');
    }
    public function loadSetnoByParty() {
        self::loadBlock('outpass/outpassBlock');
        outpassBlock::loadSetnoByParty();
    }
    public function loadSetNoDesign() {
        self::loadBlock('outpass/outpassBlock');
        self::loadDesign('outpass/loadSetNoDesign');
    }
    public function loadSetNoTextDesign() {
        self::loadBlock('outpass/outpassBlock');
        self::loadDesign('outpass/loadSetNoTextDesign');
    }
    public function loadIssueEntryPopup() {
        self::loadBlock('outpass/outpassBlock');
        self::loadDesign('outpass/issueentrypopupdesign');
    }
    public function loadReceiveEntryPopup() {
        self::loadBlock('outpass/outpassBlock');
        self::loadDesign('outpass/receiveentrypopupdesign');
    }
    public function loadIssueEntryUpdatePopup() {
        self::loadBlock('outpass/outpassBlock');
        self::loadDesign('outpass/issueentrypopupdesign');
    }
    public function loadEditSetNoDesign() {
        self::loadBlock('outpass/outpassBlock');
        self::loadDesign('outpass/loadEditSetNoDesign');
    }
    public function loadEditSetNoTextDesign() {
        self::loadBlock('outpass/outpassBlock');
        self::loadDesign('outpass/loadEditSetNoTextDesign');
    }
    public function loadReceiveEntryUpdatePopup() {
        self::loadBlock('outpass/outpassBlock');
        self::loadDesign('outpass/receiveentryupdatepopupdesign');
    }
    public function updateReceiveInvoice() {
        self::loadBlock('outpass/outpassBlock');
        $addFlag = outpassBlock::saveUpdateReceiveInvoice();
        if ($addFlag == 1) {
            self::loadDesign('outpass/addupdateissuesuccess');
        } else {
            self::loadDesign('outpass/addupdateissuefail');
            echo 'fail';
        }
    }
}
