<?php

Class Sapiha_Export_Block_Adminhtml_Export_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * @throws Exception
     */
    public function _construct()
    {
        $helper  = Mage::helper('sapiha_export');
        $this->_controller='adminhtml_export';
        $this->_blockGroup = "sapiha_export";
        $this->_headerText=$helper->__('Manage Export');

        if ($this->getRequest()->getParam('id')) {
            $this->addButton('add_new', array(
                'label' => Mage::helper('catalog')->__('Generate Export'),
                'onclick' => "setLocation('{$this->getUrl('*/*/export', array('id' => $this->getRequest()->getParam('id'))  )}')",
                'class' => 'button'
            ));
        }

        parent::_construct();
    }
}
