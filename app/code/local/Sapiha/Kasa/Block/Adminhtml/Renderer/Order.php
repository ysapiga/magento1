<?php

class Sapiha_Kasa_Block_Adminhtml_Renderer_Order extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    /**
     * Order link renderer
     *
     * @param Varien_Object $row
     * @return string
     */
    public function render(Varien_Object $row)
    {
        $orderId = $row->getData('order_id');

        return "<a href='" . $this->getUrl('*/sales_order/view', [
            'order_id' => $orderId,
        ]) . "'>$orderId</a>";
    }
}
