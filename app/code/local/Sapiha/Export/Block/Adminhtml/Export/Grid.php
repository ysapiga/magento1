<?php

class Sapiha_Export_Block_Adminhtml_Export_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * @inheritdoc
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('sapiha_export/export')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('export');

        $this->getMassactionBlock()->addItem('delete', array(
            'label' => $this->__('Export'),
            'url' => $this->getUrl('*/*/massExport'),
        ));
        return $this;
    }

    /**
     * @inheritdoc
     */
    protected function _prepareColumns()
    {
        $helper = Mage::helper('sapiha_export');
        $this->addColumn('id', array(
            'header' => $helper->__('Export ID'),
            'index' => 'id',
            'width' => '50px',
        ));
        $this->addColumn('title', array(
            'header' => $helper->__('Title'),
            'index' => 'title',
            'type'  => 'text',

        ));
        $this->addColumn('file_name', array(
            'header' => $helper->__('File Name'),
            'index' => 'file_name',
            'type' => 'text',

        ));
        $this->addColumn('is_active', array(
            'header' => $helper->__('Is Active'),
            'index' => 'is_active',
            'type' => 'options',
            'options'   => array(
                1 => Mage::helper('sapiha_export')->__('Active'),
                0 => Mage::helper('sapiha_export')->__('Inactive')
            )
        ));
        return parent::_prepareColumns();
    }

    /**
     * @param $model
     * @return string
     */
    public function getRowUrl($model)
    {
        return $this->getUrl('*/*/edit', array(
            'id'=>$model->getId(),
        ));
    }
}
