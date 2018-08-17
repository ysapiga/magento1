<?php

class Sapiha_News_Block_Adminhtml_News_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * @inheritdoc
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('news_form');
        $this->setTitle(Mage::helper('sapiha_news')->__('News Information'));
    }

    /**
     * @inheritdoc
     */
    protected function _prepareForm()
    {
        $helper = Mage::helper('sapiha_news');
        $model = Mage::registry('current_news');
        $form = new Varien_Data_Form(
            array(
                'id' => 'edit_form',
                'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
                'method' => 'post',
                'enctype' => 'multipart/form-data'
            )
        );
        $fieldset = $form->addFieldset('news_form', array('legend' => $helper->__('News Information')));

        $fieldset->addField('title', 'text', array(
            'label' => $helper->__('Title'),
            'required' => true,
            'name' => 'title',
        ));
        $fieldset->addField('image', 'image', array(
            'label' => "image",
            'required' => false,
            'name' => 'image',
        ));
        $fieldset->addField('content', 'editor', array(
            'label' => $helper->__('Content'),
            'required' => true,
            'name' => 'content',
        ));
        $form->setHtmlIdPrefix('news_');

        if (isset($model)) {
            $form->setValues($model->getData());
        }

        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
