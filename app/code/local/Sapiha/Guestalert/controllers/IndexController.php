<?php

class Sapiha_Guestalert_IndexController extends Mage_Core_Controller_Front_Action
{
    /**
     * Add price alert action
     *
     * @throws Varien_Exception
     * @return void
     */
    public function addPriceAction()
    {
        if ($post = $this->getRequest()->getPost()) {

            try {
                $productId = $this->getRequest()->getParam('id');
                $product  = Mage::getModel('catalog/product')->load($productId);
                $modelManager = Mage::getModel('sapiha_guestalert/manager');
                $modelManager->savePriceModel($post, $productId);
                $this->_redirect($product->getUrlPath());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect($product->getUrlPath());
            }
        }
    }

    /**
     * Add stock alert action
     *
     * @throws Varien_Exception
     * @return void
     */
    public function addStockAction()
    {
        if ($post = $this->getRequest()->getPost()) {

            try {
                $productId = $this->getRequest()->getParam('id');
                $product  = Mage::getModel('catalog/product')->load($productId);
                $post = $this->getRequest()->getPost();
                $modelManager = Mage::getModel('sapiha_guestalert/manager');
                $modelManager->saveStockModel($post, $productId);
                $this->_redirect($product->getUrlPath());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect($product->getUrlPath());
            }
        }
    }
}
