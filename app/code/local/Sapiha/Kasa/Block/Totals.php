<?php

class Sapiha_Kasa_Block_Totals extends Mage_Core_Block_Abstract
{
    /**
     * @inheritdoc
     */
    public function initTotals()
    {
        $order = $this->getParentBlock()->getSource();
        $kasaAmount = Mage::getModel('sapiha_kasa/robberyorder');
        $kasaAmount = $kasaAmount->load($kasaAmount->getResource()->loadByOrderId($order->getId()));

        if ($kasaAmount->getRobberyAmount()) {
            $total = new Varien_Object(array(
                'code' => Sapiha_Kasa_Model_Method::CODE,
                'field' => 'base_percent',
                'value' => $kasaAmount->getRobberyAmount(),
                'label' => Mage::helper('sapiha_kasa')->__('Kasa Looted Coins')
            ));
            $this->getParentBlock()->addTotal($total);
        }

        return $this;
    }
}
