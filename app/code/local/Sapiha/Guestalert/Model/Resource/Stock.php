<?php
class Sapiha_Guestalert_Model_Resource_Stock extends Mage_Core_Model_Mysql4_Abstract
{
    /**
     * @inheritdoc
     */
    public function _construct()
    {
        $this->_init('sapiha_guestalert/table_stock', 'product_stock_id');
    }
}
