<?php

class Sapiha_Export_Block_Adminhtml_Export_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * Sapiha_Export_Block_Adminhtml_Export_Edit_Tabs constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('export_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('sapiha_export')->__('Block Information'));
    }

    /**
     * @return Mage_Core_Block_Abstract
     */
    protected function _prepareLayout()
    {
        $this->addTab('main_tab',array(
            'label' => $this->__('Main'),
            'title' => $this->__('Main'),
            'content' => $this->getLayout()->createBlock('sapiha_export/adminhtml_export_edit_tabs_main')->toHtml()
        ));
        $this->addTab('filter_tab',array(
            'label' => $this->__('Filter tab'),
            'title' => $this->__('Filter tab'),
            'content' => $this->getLayout()->createBlock('sapiha_export/adminhtml_export_edit_tabs_filter')->toHtml()
        ));
        $this->addTab('categories', array(
            'label'     => Mage::helper('sapiha_export')->__('Categories'),
            'url'       => $this->getUrl('*/*/categories', array('_current' => true)),
            'class'     => 'ajax',
        ));

        return parent::_prepareLayout();
    }
}
