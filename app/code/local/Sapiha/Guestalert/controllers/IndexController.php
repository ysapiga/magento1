<?php

class Sapiha_Guestalert_IndexController extends Mage_Core_Controller_Front_Action
{
    /**
     * Add price alert action triggering
     *
     * @throws Varien_Exception
     * @return void
     */
    public function addPriceAction()
    {
        $this->_process(Sapiha_Guestalert_Model_Manager::TYPE_PRICE);
    }

    /**
     * Add stock alert action triggering
     *
     * @throws Varien_Exception
     * @return void
     */
    public function addStockAction()
    {
       $this->_process(Sapiha_Guestalert_Model_Manager::TYPE_STOCK);
    }

    /**
     * Proccess alert action
     *
     * @param string $type
     * @throws Varien_Exception
     */
    public function _process($type)
    {
        if ($post = $this->getRequest()->getPost()) {

            try {
                $productId = $this->getRequest()->getParam('id');
                $product  = Mage::getModel('catalog/product')->load($productId);
                $post = $this->getRequest()->getPost();
                $modelManager = Mage::getModel('sapiha_guestalert/manager');

                if ($type == Sapiha_Guestalert_Model_Manager::TYPE_STOCK) {
                    $modelManager->saveStockModel($post, $productId);
                } else if ($type == Sapiha_Guestalert_Model_Manager::TYPE_PRICE) {
                    $modelManager->savePriceModel($post, $productId);
                }
                Mage::getModel('core/session')->addSuccess($this->__('You was successfully subscribed'));

            } catch (Exception $e) {
                Mage::getModel('core/session')->addError($this->__('Something went wrong'));
                Mage::logException($e);
            }

            $this->_redirect($product->getUrlPath());
        }
    }

}
