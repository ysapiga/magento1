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

    const TYPE_STOCK = 'stock';

    const TYPE_PRICE = 'price';

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
        if ($this->checkCandidate($post['guest_email'], $productId, self::TYPE_STOCK)) {
            $this->stockAlertModel->setData($post);
            $this->stockAlertModel->setProductId($productId);
            $this->stockAlertModel->setPrice($this->_getProduct($productId)->getFinalPrice());
            $this->stockAlertModel->save();
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
        if ($this->checkCandidate($post['guest_email'], $productId, self::TYPE_PRICE)) {
            $this->priceAlertModel->setData($post);
            $this->priceAlertModel->setProductId($productId);
            $this->priceAlertModel->setPrice($this->_getProduct($productId)->getFinalPrice());
            $this->priceAlertModel->save();
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
        switch ($type) {
            case self::TYPE_PRICE :
                $model = Mage::getModel('sapiha_guestalert/price');
                break;
            case self::TYPE_STOCK :
                $model = Mage::getModel('sapiha_guestalert/stock');
                break;
            default :
                $model = null;
                throw new Exception("Unsuported alert type $type");
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
