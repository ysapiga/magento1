<?php
class Sapiha_Trial_Block_Advertising extends Mage_Core_Block_Template
{

    public function couldBeShowed()
    {
        $permission = $this->checkAction();
        if(Mage::registry('current_product') && Mage::registry('current_product')->getSku()=="advertising"){
            $permission = true;
        }
        return $permission;
    }

    public function checkAction()
    {
        $permission = false;
        if($this->getRequest()->getActionName() =='advertising'){
            $permission = true;
        }
        return $permission;

    }

}
