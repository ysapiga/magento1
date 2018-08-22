<?php

class Sapiha_Kasa_Block_Adminhtml_Kasa_Container extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * Sapiha_Kasa_Block_Adminhtml_Kasa_Container constructor.
     */
    public function __construct()
    {
        $this->_blockGroup = 'sapiha_kasa';
        $this->_controller = 'adminhtml_kasa';
        $this->_headerText = $this->__('Kasa Payment Info');

        parent::__construct();
        $this->_removeButton('add');
    }
}
