<?php
class Sapiha_Guestalert_Model_Resource_Stock_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    /**
     * @inheritdoc
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('sapiha_guestalert/stock');
    }
}
