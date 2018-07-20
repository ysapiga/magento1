<?php

class Sapiha_Banner_Block_Adminhtml_Banner_Edit_Options extends Mage_Adminhtml_Block_Widget
{
    /**
     * Prepare edit options tap
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return Varien_Data_Form_Element_Abstract
     */
    public function prepareElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $widgetInstance = Mage::registry('current_widget_instance');
        $banner = Mage::getModel('sapiha_banner/banner');

        if ($widgetInstance !== null) {
            $clickAmount = $banner->load($banner->getResource()->getIdByWidgetId($widgetInstance->getId()))->getClickCount();
            $parameters = $widgetInstance->getWidgetParameters();
        }

        $helper = Mage::helper('sapiha_banner');
        $fieldset = new Varien_Data_Form_Element_Fieldset();
        $fieldset->addField('upload', 'button', array(
            'value' => Mage::helper('sapiha_banner')->__('Upload Image'),
        ));
        $fieldset->addField('link', 'text', array(
            'name' => 'parameters[link]',
            'value' => !empty($parameters['link']) ? $parameters['link'] : '',
            'required' => false,
            'class' => 'validate-url',
        ));
        $fieldset->addField('instance_id', 'hidden', array(
            'name' => 'parameters[instance_id]',
            'value' => !empty($parameters['instance_id']) ? $parameters['instance_id'] : '',
            'required' => false,
        ));
        $fieldset->addType('cropper', 'Sapiha_Banner_Block_Adminhtml_Banner_Renderer_Cropper');
        $fieldset->addField('banner_grid', 'cropper', array(
            'name' => 'parameters[image]',
            'label' => $helper->__('Crop'),
            'view_type' => 'grid',
            'ratio' => Mage::getStoreConfig('sapiha_banner/sapiha_banner_group/grid_image_ratio', Mage::app()->getStore()),
            'required' => true,
        ));
        $fieldset->addField('grid_position', 'text', array(
            'label' => $helper->__('Banner grid position'),
            'name' => 'parameters[grid_position]',
            'value' => !empty($parameters['grid_position']) ? $parameters['grid_position'] : '',
            'required' => true,
            'class' => 'validate-greater-than-zero',
        ));
        $fieldset->addField('banner_list', 'cropper', array(
            'name' => 'parameters[image_list]',
            'label' => $helper->__('Crop'),
            'view_type' => 'list',
            'ratio' => Mage::getStoreConfig('sapiha_banner/sapiha_banner_group/list_image_ratio', Mage::app()->getStore()),
            'required' => true,
        ));
        $fieldset->addField('list_position', 'text', array(
            'label' => $helper->__('Banner list position'),
            'name' => 'parameters[list_position]',
            'value' => !empty($parameters['list_position']) ? $parameters['list_position'] : '',
            'required' => true,
            'class' => 'validate-greater-than-zero',
        ));
        $fieldset->addField('click_amount', 'text', array(
            'label' => $helper->__('Amount of banner clicks'),
            'readonly' => true,
            'value' => !empty($clickAmount) ? $clickAmount : '0',
            'required' => true,
        ));
        $fieldset->addField('description', 'editor', array(
            'label' => $helper->__('Content'),
            'name' => 'parameters[content]',
            'required' => true,
            'value' => !empty($parameters['content']) ? $parameters['content'] : '',
            'config' => Mage::getSingleton('cms/wysiwyg_config')->getConfig()
        ));
        $element->setData('after_element_html', $fieldset->getChildrenHtml());

        return $element;
    }
}
