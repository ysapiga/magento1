<?php

class Sapiha_Export_Block_Adminhtml_Export_Edit_Tabs_Filter extends Mage_Adminhtml_Block_Widget_Form
{

    /**
     * Sapiha_Export_Block_Adminhtml_Export_Edit_Tabs_Filter constructor.
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
            'legend' => $helper->__('Chose filters')
        ));


        $fieldset->addField('minimum_qty', 'text', array(
            'label' => $helper->__('Minimum qty'),
            'required' => true,
            'name'=>'minimum_qty',
        ));
        $fieldset->addField('action', 'select', array(
            'label' => $helper->__('Action'),
            'required' => false,
            'name'=>'action',
            'values' => (array(
                'yes' => $helper->__('YES'),
                'no' => $helper->__('NO'),
                '' => $helper->__('Not Selected')
            ))
        ));
        $fieldset->addField('providers', 'select', array(
            'label' => $helper->__('Provider'),
            'required' => false,
            'name'=>'providers',
            'values' => (array(
                'provider1' => $helper->__('Provider 1'),
                'provider2' => $helper->__('Provider 2'),
                '' => $helper->__('Not Selected')
            ))
        ));
        $fieldset->addField('markdown', 'select', array(
            'label' => $helper->__('Markown'),
            'required' => false,
            'name'=>'markdown',
            'values' => (array(
                'yes' => $helper->__('YES'),
                'no' => $helper->__('NO'),
                '' => $helper->__('Not Selected')
            ))
        ));
        $form->setUseContainer(false);

        if ($this->getRequest()->getParam('id')) {
            $form->setValues($formValues);
        }

        $this->setForm($form);
        return parent::_prepareForm();
    }
}
