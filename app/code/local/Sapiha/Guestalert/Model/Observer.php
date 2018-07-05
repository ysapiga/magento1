<?php

class Sapiha_Guestalert_Model_Observer extends Mage_Core_Helper_Abstract
{
    /**
     * Price alert template configuration
     */
    const XML_PATH_TO_PRICE_ALERT_TEMPLATE = 'sapiha_guestalert/sapiha_guestalert_group/email_price_template';

    /**
     * Stock Alert template configuration
     */
    const XML_PATH_TO_STOCK_ALERT_TEMPLATE = 'sapiha_guestalert/sapiha_guestalert_group/email_price_template';

    /**
     * Warning (exception) errors array
     *
     * @var array
     */
    protected $_errors = array();

    /**
     * Get product by id
     *
     * @param int $id
     * @return Mage_Catalog_Model_Product
     */
    public function getProduct($id) {
        return  Mage::getModel('catalog/product')->load($id);
    }

    /**
     * Send price alert messages to subscribers
     *
     * @throws Mage_Core_Model_Store_Exception
     * @throws Varien_Exception
     * @return void
     */
    public function sendPriceMessages() {
        $collection = Mage::getModel('sapiha_guestalert/price')->getCollection();

        foreach ($collection as $item) {
            $product = $this->getProduct($item->getProductId());
            if ($product->getFinalPrice() < $item->getPrice()) {
                $emailTemplate  = Mage::getModel('core/email_template')
                    ->loadDefault(Mage::getStoreConfig(self::XML_PATH_TO_PRICE_ALERT_TEMPLATE, Mage::app()->getStore()));
                $emailTemplateVariables = array();
                $emailTemplateVariables['name'] = $item->getGuestName();
                $emailTemplateVariables['email'] = $item->getGuestEmail();
                $emailTemplateVariables['productPrice'] = $product->getFinalPrice();
                $emailTemplateVariables['productName'] = $product->getName();
                $emailTemplateVariables['store'] = Mage::app()->getStore();
                try {
                    $emailTemplate->send($item->getGuestEmail(), $item->getGuestName, $emailTemplateVariables);
                    $item->setPrice($product->getFinalPrice())->save();
                } catch (Exception $e) {
                    $this->_errors[] = $e->getMessage();
                }
            }
        }
    }

    /**
     * Send stock alert messages to subscribers
     *
     * @throws Mage_Core_Model_Store_Exception
     * @throws Varien_Exception
     * @return void
     */
    public function sendStockMessages() {
        $collection = Mage::getModel('sapiha_guestalert/stock')->getCollection()
            ->addFieldToFilter('status', 0);

        foreach ($collection as $item) {
            $product = $this->getProduct($item->getProductId());
            if ($product->isInStock()) {
                $emailTemplate  = Mage::getModel('core/email_template')
                    ->loadDefault(Mage::getStoreConfig(self::XML_PATH_TO_STOCK_ALERT_TEMPLATE, Mage::app()->getStore()));
                $emailTemplateVariables = array();
                $emailTemplateVariables['name'] = $item->getGuestName();
                $emailTemplateVariables['email'] = $item->getGuestEmail();
                $emailTemplateVariables['productPrice'] = $product->getFinalPrice();
                $emailTemplateVariables['productName'] = $product->getName();
                $emailTemplateVariables['store'] = Mage::app()->getStore();
                try {
                    $emailTemplate->send($item->getGuestEmail(), $item->getGuestName, $emailTemplateVariables);
                    $item->setStatus(1)->save();
                } catch (Exception $e) {
                    $this->_errors[] = $e->getMessage();
                }
            }
        }
    }

    /**
     * Trigger message send
     *
     * @return void
     */
    public function process()
    {
        $this->sendPriceMessages();
        $this->sendStockMessages();
    }
}
