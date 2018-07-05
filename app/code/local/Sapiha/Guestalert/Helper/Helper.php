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
        $permission = false;
        if ($this->IsCustomerLogged()) {
        $permission = Mage::getStoreConfigFlag(Mage_ProductAlert_Model_Observer::XML_PATH_STOCK_ALLOW);
        }

        return $permission;
    }

    /**
     * Check whether price alert is allowed
     *
     * @return bool
     */
    public function isPriceAlertAllowed()
    {
        $permission = false;
        if ($this->IsCustomerLogged()) {
            $permission = Mage::getStoreConfigFlag(Mage_ProductAlert_Model_Observer::XML_PATH_PRICE_ALLOW);
        }

        return $permission;
    }

    public function IsCustomerLogged()
    {
        return Mage::helper('customer')->isLoggedIn();
    }
}
