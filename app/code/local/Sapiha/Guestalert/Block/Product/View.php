<?php

class Sapiha_Guestalert_Block_Product_View extends Mage_ProductAlert_Block_Product_View
{
    /**
     * Check whether the stock alert data can be shown and prepare related data
     *
     * @return void
     */
    public function prepareStockAlertData()
    {
        if (!$this->_getHelper()->isStockAlertAllowed() || !$this->_product || $this->_product->isAvailable()) {
            $this->setTemplate('sapiha_guestalert/price.phtm');

            return;
        }
        $this->setSignupUrl($this->_getHelper()->getSaveUrl('stock'));
    }

    /**
     * Check whether the price alert data can be shown and prepare related data
     *
     * @return void
     */
    public function preparePriceAlertData()
    {
        if (!$this->_getHelper()->isPriceAlertAllowed()
            || !$this->_product || false === $this->_product->getCanShowPrice()
        ) {
            $this->setTemplate('sapiha_guestalert/price.phtml');

            return;
        }
        $this->setSignupUrl($this->_getHelper()->getSaveUrl('price'));
    }


    /**
     * Check is product in stock
     *
     * @return bool
     */
    public function canShowStockForm()
    {
        $permission = false;
        $product = Mage::getModel('catalog/product')->load($this->getRequest()->getParam('id'));
        if ($product->getIsInStock() == '0') {
            $permission = true;
        }

        return $permission;
    }
}
