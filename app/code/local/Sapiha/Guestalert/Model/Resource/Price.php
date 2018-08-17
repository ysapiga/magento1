<?php
class Sapiha_Guestalert_Model_Resource_Price extends Mage_Core_Model_Mysql4_Abstract
{
    /**
     * @inheritdoc
     */
    public function _construct()
    {
        $this->_init('sapiha_guestalert/table_price', 'product_price_id');
    }
}
