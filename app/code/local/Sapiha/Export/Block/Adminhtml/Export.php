<?php

class Sapiha_Export_Block_Adminhtml_Export extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        parent::_construct();
        $helper = Mage::helper('sapiha_export');
        $this->_blockGroup = 'sapiha_export';
        $this->_controller = 'adminhtml_export';
        $this->_headerText = $helper->__('Export Management');
        $this->_addButtonLabel = $helper->__('Add Export');
    }
}
