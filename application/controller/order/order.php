<?php

class order extends Controller {

    public function index() {
        
    }

    public function makeNewOrder() {
        self::loadBlock('order/salesNewOrderBlock');
        $addFlag = salesNewOrderBlock::saveOrder();
        if ($addFlag == 1) {
            self::loadDesign('sales/addNewSalesBillSuccess');
        } else {
            self::loadDesign('sales/addNewSalesBillFail');
            echo 'fail';
        }
    }

}
