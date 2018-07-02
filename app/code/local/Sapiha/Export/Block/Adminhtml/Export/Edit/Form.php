<?php

class Sapiha_Export_Block_Adminhtml_Export_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Sapiha_Export_Block_Adminhtml_Export_Edit_Form constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('export_form');
        $this->setTitle(Mage::helper('sapiha_export')->__('Export Information'));
    }

    /**
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        $model = Mage::registry('current_export');
        $form = new Varien_Data_Form(
            array(
                'id' => 'edit_form',
                'action' => $this->getUrl('*/*/save',array('id'=>$this->getRequest()->getParam('id'))),
                'method' => 'post',
                'enctype' => 'multipart/form-data'
            )
        );
        $form->setHtmlIdPrefix('export_');
        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
