<?php

class Sapiha_Trial_Block_Advertising extends Mage_Core_Block_Template
{
    /**
     * Check permission for block load
     *
     * @return bool
     */
    public function couldBeShowed()
    {
        $permission = $this->checkAction();
        $currentProduct = Mage::registry('current_product');
        if (isset($currentProduct) && $currentProduct->getSku() == 'advertising') {
            $permission = true;
        }
        return $permission;
    }

    /**
     * Check current actionName
     *
     * @return bool
     */
    public function checkAction()
    {
        $permission = false;
         $this->getLayout()->getUpdate()->getHandles();
        if (in_array('sapiha_trial_index_advertising', $this->getLayout()->getUpdate()->getHandles())) {
            $permission = true;
        }
        return $permission;
    }
}
