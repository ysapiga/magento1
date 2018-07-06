<?php

class Sapiha_Export_Block_Adminhtml_Export_Edit_Tabs_Main extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Sapiha_Export_Block_Adminhtml_Export_Edit_Tabs_Main constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('main_form');
        $this->setTitle(Mage::helper('sapiha_export')->__('Block Information'));
    }

    /**
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        $helper = Mage::helper('sapiha_export');
        $model = Mage::registry('current_export');
        $formValues = $model->getData();

        $form = new Varien_Data_Form();
        $fieldset = $form->addFieldset('main_form', array(
            'legend' => $helper->__('Main Information')
        ));
        $fieldset->addField('title', 'text', array(
            'label' => $helper->__('Export Name'),
            'required' => true,
            'name'=>'title',
        ));
        $fieldset->addField('file_name', 'text', array(
            'label' => $helper->__('File Name'),
            'required' => true,
            'name'=>'file_name',
        ));
        $fieldset->addField('is_active', 'select', array(
            'label' => $helper->__('Enabled'),
            'required' => true,
            'name'=>'is_active',
            'values' =>  array(
                array('value' => '1', 'label' => 'YES'),
                array('value' => '0', 'label' => 'NO'),
            )
        ));
        $fieldset->addField('format', 'select', array(
            'label' => $helper->__('Format'),
            'required' => true,
            'name'=>'format',
            'values' => (array(
                '.json' => $helper->__('JSON'),
                '.yaml' => $helper->__('YAML')
            ))
        ));

        $form->setUseContainer(false);
        $form->setValues($formValues);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
