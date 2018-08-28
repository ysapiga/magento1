<?php

class Sapiha_Kasa_Block_Sales_Order_Totals extends Mage_Core_Block_Abstract
{
    /**
     * @inheritdoc
     */
    public function initTotals()
    {
        $order = $this->getOrder();
        $kasaAmount = Mage::getModel('sapiha_kasa/robberyorder');
        $orderId = $order->getId();

        if ($orderId !== null) {
            $kasaAmount = $kasaAmount->load($orderId, 'order_id');
        } else {
            $kasaAmount = $kasaAmount->load($order->getData('order_id'), 'order_id');
        }

        if ($kasaAmount->getRobberyAmount()) {
            $kasaComission = new Varien_Object([
                'code' => Sapiha_Kasa_Model_Method::CODE,
                'field' => 'base_percent',
                'value' => $kasaAmount->getKasaPercent(),
                'label' => Mage::helper('sapiha_kasa')->__('Kasa Comission')
            ]);
            $this->getParentBlock()->addTotal($kasaComission);
            $total = new Varien_Object([
                'field' => 'base_percent',
                'value' => $kasaAmount->getRobberyAmount(),
                'label' => Mage::helper('sapiha_kasa')->__('Kasa Looted Coins')
            ]);
            $this->getParentBlock()->addTotal($total);
        }

        return $this;
    }

    /**
     * Get current order
     *
     * @return Mage_Sales_Model_Order
     * @throws Varien_Exception
     */
    private function getOrder()
    {
        $handles =  $handles = $this->getLayout()->getUpdate()->getHandles();
        $permission = false;
        $neededHandles = [
            'sales_order_creditmemo',
            'sales_order_invoice',
            'adminhtml_sales_order_invoice_view',
            'adminhtml_sales_order_creditmemo_view',
        ];

        foreach ($neededHandles as $handle)
        {
            if (in_array($handle, $handles))
            {
                $permission = true;
                break;
            }
        }

        return $permission ? $this->getParentBlock()->getSource()->getOrder() :  $this->getParentBlock()->getSource();
    }
}
