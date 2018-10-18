<?php

class Sapiha_Export_Model_Export extends Mage_Core_Model_Abstract
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
