<?php

class Sapiha_News_Block_Adminhtml_News_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * @inheritdoc
     */
    public function _construct()
    {
        $this->_controller='adminhtml_news';
        $this->_blockGroup = "sapiha_news";
        $this->_headerText="News Managment";
        parent::_construct();
    }
}
