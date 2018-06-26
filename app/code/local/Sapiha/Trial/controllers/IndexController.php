<?php

class Sapiha_Trial_IndexController extends Mage_Core_Controller_Front_Action
{
    /**
     * Test controller
     *
     * @return void
     */
    public function indexAction()
    {
        echo "Hello Magento";
    }

    /**
     * Load advertising block
     *
     * @return void
     */
    public function advertisingAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }
}
