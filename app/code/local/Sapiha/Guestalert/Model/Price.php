<?php
class Sapiha_Guestalert_Model_Price extends Mage_Core_Model_Abstract
{
    /**
     * @inheritdoc
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('sapiha_guestalert/price');
    }
}
