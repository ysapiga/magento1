<?php

class Sapiha_Export_Model_Resource_Export_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    /**
     * @inheritdoc
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('sapiha_export/export');
    }
}
