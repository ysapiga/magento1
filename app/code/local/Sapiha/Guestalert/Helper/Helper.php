<?php

class Sapiha_Guestalert_Helper_Helper extends Mage_ProductAlert_Helper_Data
{
    /**
     * Check whether stock alert is allowed
     *
     * @return bool
     */
    public function isStockAlertAllowed()
    {
        $stockAlertPermission = Mage::getStoreConfigFlag(Mage_ProductAlert_Model_Observer::XML_PATH_STOCK_ALLOW);
        $permission = ($this->IsCustomerLogged()) ? $stockAlertPermission : false;

        return $permission;
    }

    /**
     * Check whether price alert is allowed
     *
     * @return bool
     */
    public function isPriceAlertAllowed()
    {

        $priceAlertPermission =  Mage::getStoreConfigFlag(Mage_ProductAlert_Model_Observer::XML_PATH_PRICE_ALLOW);
        $permission = ($this->IsCustomerLogged()) ? $priceAlertPermission  : false;

        return $permission;
    }

    /**
     * Check is customer logged in
     *
     * @return bool
     */
    public function IsCustomerLogged()
    {
        return Mage::helper('customer')->isLoggedIn();
    }
}
