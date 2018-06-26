<?php
Class Sapiha_Trial_IndexController extends Mage_Core_Controller_Front_Action
{
    public function IndexAction()
    {
        echo "Hello Magento";
    }

    public function AdvertisingAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }
}