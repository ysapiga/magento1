<?php

class Sapiha_Banner_Model_Banner extends Mage_Core_Model_Abstract
{
    /**
     * Sapiha_Banner_Model_Banner Constructor
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('sapiha_banner/banner');
    }
}
