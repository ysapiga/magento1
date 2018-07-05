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
                $helper = Mage::helper('sapiha_guestalert');
                $productId = $this->getRequest()->getParam('id');
                $product  = Mage::getModel('catalog/product')->load($productId);
                $model = Mage::getModel('sapiha_guestalert/price');

                if ($helper->checkCandidate($post['guest_email'], $productId, 'price')) {
                    $model->setData($post);
                    $model->setProductId($productId);
                    $model->setPrice($product->getFinalPrice());
                    $model->save();
                    $this->_redirect('cms/index/index');
                    Mage::getSingleton('core/session')->addSuccess('You was successfully subscribed');
                } else {
                    $this->_redirect('cms/index/index');
                    Mage::getSingleton('core/session')->addError('You already subscribed');
                }

            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('cms/index/index');
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
                $helper = Mage::helper('sapiha_guestalert');
                $productId = $this->getRequest()->getParam('id');
                $post = $this->getRequest()->getPost();
                $model = Mage::getModel('sapiha_guestalert/stock');
                if ($helper->checkCandidate($post['guest_email'], $productId, 'stock')) {
                    $model->setData($post);
                    $model->setProductId($productId);
                    $model->save();
                    $this->_redirect('cms/index/index');
                    Mage::getSingleton('core/session')->addSuccess('You was successfully subscribed');
                }
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('cms/index/index');
            }
        }
    }
}
