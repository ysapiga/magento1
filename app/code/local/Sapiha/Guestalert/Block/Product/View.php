<?php

class Sapiha_Guestalert_Block_Product_View extends Mage_ProductAlert_Block_Product_View
{
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
        } else {
            $this->setSignupUrl($this->_getHelper()->getSaveUrl('price'));
        }
    }


    /**
     * Check is product in stock
     *
     * @return bool
     */
    public function canShowStockForm()
    {
        return $this->_product->getIsInStock() == '0';
    }
}
