<?php

class hsnCode extends Controller {

    public function index() {
        
    }

    public function newHsnCodeForm() {
        self::loadBlock('customer/customerBlock');
        self::loadDesign('HsnCode/newHsnCode'); 
    }
    
    public function updateHsn() {
        self::loadBlock('customer/customerBlock');
        self::loadDesign('HsnCode/updateHsn'); 
    }
    
    public function loadHsnDetails() {
        self::loadBlock('customer/customerBlock');
        self::loadDesign('HsnCode/updateHsnDetails'); 
    }
     
 public function addHsn() {
        self::loadBlock('customer/customerBlock');
        $addFlag=customerBlock::addHsn();
         if($addFlag ==1 ){
            self::loadDesign('HsnCode/addHsnSuccess');
        }
        else
        {
             self::loadDesign('HsnCode/addHsnFail');
             
        }
        
   }
   public function hsnUpDate() {
        self::loadBlock('customer/customerBlock');
        $addFlag=customerBlock::hsnUpDate();
         if($addFlag ==1 ){
            self::loadDesign('hsncode/updateHsnSuccess');
        }
        else
        {
             self::loadDesign('hsncode/updateHsnSuccess');
        }
         
        
   }
}
