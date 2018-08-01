<?php

class Sapiha_Kasa_Block_Adminhtml_Kasa extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        parent::_construct();
        $helper = Mage::helper('sapiha_kasa');
        $this->_blockGroup = 'sapiha_kasa';
        $this->_controller = 'adminhtml_kasa';
        $this->_headerText = $helper->__('Kasa Management');
    }
}
