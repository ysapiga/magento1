<?php

class Sapiha_Guestalert_Model_Manager extends Mage_Core_Model_Abstract
{
    /**
     * @var Sapiha_Guestalert_Model_Stock
     */
    private $stockAlertModel;

    /**
     * @var Sapiha_Guestalert_Model_Price
     */
    private $priceAlertModel;

    /**
     * Sapiha_Guestalert_Model_Manager constructor
     */
    public function _construct()
    {
        parent::_construct();
        $this->stockAlertModel = Mage::getModel('sapiha_guestalert/stock');
        $this->priceAlertModel = Mage::getModel('sapiha_guestalert/price');
    }

    /**
     * Save StockAlert Model
     *
     * @param array $post
     * @param string $productId
     * @throws Varien_Exception
     * @return void
     */
    public function saveStockModel($post, $productId)
    {
        if ($this->checkCandidate($post['guest_email'], $productId, 'stock')) {

            try {
                $this->stockAlertModel->setData($post);
                $this->stockAlertModel->setProductId($productId);
                $this->stockAlertModel->setPrice($this->_getProduct($productId)->getFinalPrice());
                $this->stockAlertModel->save();
                Mage::getSingleton('core/session')->addSuccess('You was successfully subscribed');
            } catch (Exception $e) {
                Mage::getSingleton('core/session')->addError('Something went wrong');
            }

        } else {
            Mage::getSingleton('core/session')->addError('You already subscribed');
        }
    }

    /**
     * Save PriceAlert Model
     *
     * @param array $post
     * @param string $productId
     * @throws Varien_Exception
     * @return void
     */
    public function savePriceModel($post, $productId)
    {
        if ($this->checkCandidate($post['guest_email'], $productId, 'price')) {

            try{
                $this->priceAlertModel->setData($post);
                $this->priceAlertModel->setProductId($productId);
                $this->priceAlertModel->setPrice($this->_getProduct($productId)->getFinalPrice());
                $this->priceAlertModel->save();
                Mage::getSingleton('core/session')->addSuccess('You was successfully subscribed');
            } catch (Exception $e) {
                Mage::getSingleton('core/session')->addError('Something went wrong');
            }

        } else {
            Mage::getSingleton('core/session')->addError('You already subscribed');
        }
    }

    /**
     * Get product by Id
     *
     * @param string $id
     * @return Mage_Catalog_Model_Product
     */
    public function _getProduct($id)
    {
        return Mage::getModel('catalog/product')->load($id);
    }

    /**
     * GuestAlert model factory
     *
     * @param string $type
     * @return Sapiha_Guestalert_Model_Price|Sapiha_Guestalert_Model_Stock
     */
    public function factory($type)
    {
        $model = null;
        switch ($type) {
            case 'price' :
                $model = Mage::getModel('sapiha_guestalert/price');
                break;
            case 'stock' :
                $model = Mage::getModel('sapiha_guestalert/stock');
                break;
        }

        return $model;
    }

    /**
     * Check permission to save model
     *
     * @param string $email
     * @param string $productId
     * @param string $type
     * @return bool
     */
    public function checkCandidate($email, $productId, $type) {
        $permission = true;
        $collection =  $this->factory($type)->getCollection();

        foreach ($collection as $item) {
            if (in_array($email, $item->getData()) && in_array($productId, $item->getData())) {
                $permission = false;
            }
        }

        return $permission;
    }
}
