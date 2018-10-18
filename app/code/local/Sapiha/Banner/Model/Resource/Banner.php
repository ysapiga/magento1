<?php

class Sapiha_Banner_Model_Resource_Banner extends Mage_Core_Model_Mysql4_Abstract
{
    /**
     * @inheritdoc
     */
    public function _construct()
    {
        $this->_init('sapiha_banner/table_banner', 'id');
    }
}
