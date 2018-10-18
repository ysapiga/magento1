<?php

class Sapiha_Banner_Block_Adminhtml_Banner_Edit_Options extends Mage_Adminhtml_Block_Widget
{

    const ALLOWED_BANNER_PAGES_AMOUNT = 3;

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
            $clickAmount = $banner->load($widgetInstance->getId(), 'banner_id')->getClickCount();
            $parameters = $widgetInstance->getWidgetParameters();
        }

        $helper = Mage::helper('sapiha_banner');
        $maxGridPosition = (int) Mage::getStoreConfig('catalog/frontend/grid_per_page', Mage::app()->getStore()) * self::ALLOWED_BANNER_PAGES_AMOUNT;
        $maxListPosition = (int) Mage::getStoreConfig('catalog/frontend/list_per_page', Mage::app()->getStore()) * self::ALLOWED_BANNER_PAGES_AMOUNT;
        $fieldset = new Varien_Data_Form_Element_Fieldset();
        $fieldset->addField('name', 'text', [
            'label' => $helper->__('Name'),
            'name' => 'parameters[name]',
            'value' => !empty($parameters['name']) ? $parameters['name'] : '',
            'required' => true,
            'maxlength' => '100',
            'class' => 'validate-no-html-tags validate-length maximum-length-100',
        ]);
        $fieldset->addType('banner_image', 'Sapiha_Banner_Block_Adminhtml_Banner_Renderer_Banner_Image');
        $fieldset->addField('image', 'banner_image', [
            'name' => 'parameters[image]',
            'value' => !empty($parameters['image']) ? Mage::getBaseUrl('media') . $parameters['image'] : '',
            'view_type' => 'grid',
            'required' => true,
        ]);
        $fieldset->addField('upload', 'button', [
            'value' => Mage::helper('sapiha_banner')->__('Upload Image'),
        ]);
        $fieldset->addField('link', 'text', [
            'name' => 'parameters[link]',
            'label' => $helper->__('Link'),
            'value' => !empty($parameters['link']) ? $parameters['link'] : '',
            'required' => true,
            'class' => 'validate-url',
        ]);
        $fieldset->addField('instance_id', 'hidden', [
            'name' => 'parameters[instance_id]',
            'value' => !empty($parameters['instance_id']) ? $parameters['instance_id'] : '',
            'required' => false,
        ]);
        $fieldset->addType('cropper', 'Sapiha_Banner_Block_Adminhtml_Banner_Renderer_Cropper');
        $fieldset->addField('banner_grid', 'cropper', [
            'name' => 'parameters[image]',
            'label' => $helper->__('Crop'),
            'view_type' => 'grid',
            'ratio' => Mage::getStoreConfig('sapiha_banner/sapiha_banner_group/grid_image_ratio', Mage::app()->getStore()),
            'required' => true,
        ]);
        $fieldset->addField('grid_position', 'text', [
            'label' => $helper->__('Banner grid position'),
            'name' => 'parameters[grid_position]',
            'value' => !empty($parameters['grid_position']) ? $parameters['grid_position'] : '',
            'required' => true,
            'class' => "validate-number validate-number-range number-range-1-$maxGridPosition",
            'after_element_html' => "max range is $maxListPosition",
        ]);
        $fieldset->addField('banner_list', 'cropper', [
            'name' => 'parameters[image_list]',
            'label' => $helper->__('Crop'),
            'view_type' => 'list',
            'ratio' => Mage::getStoreConfig('sapiha_banner/sapiha_banner_group/list_image_ratio', Mage::app()->getStore()),
            'required' => true,
        ]);
        $fieldset->addField('list_position', 'text', [
            'label' => $helper->__('Banner list position'),
            'name' => 'parameters[list_position]',
            'value' => !empty($parameters['list_position']) ? $parameters['list_position'] : '',
            'required' => true,
            'class' => "validate-number validate-number-range number-range-1-$maxListPosition",
            'after_element_html' => "max range is $maxListPosition",
        ]);
        $fieldset->addField('click_amount', 'text', [
            'label' => $helper->__('Amount of banner clicks'),
            'readonly' => true,
            'value' => !empty($clickAmount) ? $clickAmount : '0',
            'required' => true,
        ]);
        $fieldset->addField('description', 'editor', [
            'label' => $helper->__('Content'),
            'name' => 'parameters[content]',
            'required' => true,
            'value' => !empty($parameters['content']) ? $parameters['content'] : '',
            'config' => Mage::getSingleton('cms/wysiwyg_config')->getConfig(),
            'class' => 'validate-length maximum-length-300',
        ]);
        $element->setData('after_element_html', $fieldset->getChildrenHtml());

        return $element;
    }
}
