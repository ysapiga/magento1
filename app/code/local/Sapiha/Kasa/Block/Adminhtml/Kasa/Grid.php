<?php

class Sapiha_Kasa_Block_Adminhtml_Kasa_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * @inheritdoc
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('sapiha_kasa/robberyorder')->getCollection();
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * @inheritdoc
     */
    protected function _prepareColumns()
    {
        $helper = Mage::helper('sapiha_kasa');
        $this->addColumn('order_id', [
            'header' => $helper->__('Order ID'),
            'index' => 'order_id',
            'width' => '50px',
            'renderer' => 'sapiha_kasa/adminhtml_renderer_order',
        ]);
        $this->addColumn('robbery_amount', [
            'header' => $helper->__('Total'),
            'index' => 'robbery_amount',
            'type' => 'text',
        ]);
        $this->addExportType('*/*/exportCsv', $helper->__('Export to CSV'));

        return parent::_prepareColumns();
    }
}
