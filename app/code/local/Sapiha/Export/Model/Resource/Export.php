<?php

class Sapiha_Export_Model_Resource_Export extends Mage_Core_Model_Mysql4_Abstract
{
    /**
     * @inheritdoc
     */
    public function _construct()
    {
        $this->_init('sapiha_export/table_export', 'id');
    }
}
