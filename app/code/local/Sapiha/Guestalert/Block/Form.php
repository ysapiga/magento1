<?php

class Sapiha_Guestalert_Block_Form extends Mage_Core_Block_Template
{
    /**
     * Get form action for guest price alert registration form
     *
     * @return string
     */
    public function getPriceActionOfForm()
    {
        return $this->getUrl('guestalert/index/addPrice', array('id'=>$this->getRequest()->getParam('id')));
    }

    /**
     * Get form action for guest stock alert registration form
     *
     * @return string
     */
    public function getStockActionOfForm()
    {
        return $this->getUrl('guestalert/index/addStock', array('id'=>$this->getRequest()->getParam('id')));
    }

    /**
     * Determine permission for block displaying
     *
     * @return bool
     */
    public function canShow()
    {
        $permission = true;

        if (Mage::helper('customer')->isLoggedIn()) {
            $permission = false;
        }

        return $permission;
    }
}
