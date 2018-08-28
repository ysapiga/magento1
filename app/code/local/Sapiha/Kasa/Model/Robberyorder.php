<?php

class Sapiha_Kasa_Model_Robberyorder extends Mage_Core_Model_Abstract
{
    /**
     * @inheritdoc
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('sapiha_kasa/robberyorder');
    }
}
