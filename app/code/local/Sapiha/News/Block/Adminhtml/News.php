<?php

class Sapiha_News_Block_Adminhtml_News extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        parent::_construct();
        $helper = Mage::helper('sapiha_news');
        $this->_blockGroup = 'sapiha_news';
        $this->_controller = 'adminhtml_news';
        $this->_headerText = $helper->__('News Management');
        $this->_addButtonLabel = $helper->__('Add News');
    }

}
