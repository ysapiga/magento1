<?php

class Sapiha_Kasa_Model_Resource_Robberyorder extends Mage_Core_Model_Mysql4_Abstract
{
    /**
     * @inheritdoc
     */
    public function _construct()
    {
        $this->_init('sapiha_kasa/table_kasa_order', 'robbery_id');
    }
}
