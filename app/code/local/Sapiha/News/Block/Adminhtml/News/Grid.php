<?php

class Sapiha_News_Block_Adminhtml_News_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * @inheritdoc
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('sapiha_news/news')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * @inheritdoc
     */
    protected function _prepareColumns()
    {
        $helper = Mage::helper('sapiha_news');
        $this->addColumn('id', array(
            'header' => $helper->__('News ID'),
            'index' => 'id',
            'width' => '50px'
        ));
        $this->addColumn('content', array(
            'header' => $helper->__('Title'),
            'index' => 'title',
            'type' => 'text',
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
