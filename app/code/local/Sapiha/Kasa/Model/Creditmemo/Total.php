<?php

class Sapiha_Kasa_Model_Creditmemo_Total extends Mage_Sales_Model_Order_Creditmemo_Total_Abstract
{
    /**
     * Collect refund totals
     *
     * @param Mage_Sales_Model_Order_Creditmemo $address
     * @return $this|Mage_Sales_Model_Order_Creditmemo_Total_Abstract
     */
    public function collect(Mage_Sales_Model_Order_Creditmemo $creditmemo)
    {
        $subtotal = $creditmemo ->getOrder()->getBaseSubtotal();
        $baseDiscount = $creditmemo->getOrder()->getBaseDiscountAmount();
        $taxAmount = $creditmemo->getOrder()->getBaseTaxAmount();
        $shippingAmount = $creditmemo->getOrder()->getShippingAmount();
        $kasaComision = $subtotal * 0.03;
        $finalPrice = $subtotal + $kasaComision + $baseDiscount + $taxAmount + $shippingAmount;

        if (filter_var($finalPrice, FILTER_VALIDATE_INT)) {
            $lootedCoins = 1;
            $finalPrice = $finalPrice + $lootedCoins;
        } else {
            $lootedCoins = ceil($finalPrice) - $finalPrice;
            $finalPrice = ceil($finalPrice);
        }

        $creditmemo->setLootedCoins($lootedCoins);
        $creditmemo->setCustomDiscount($kasaComision);
        $creditmemo->setGrandTotal($finalPrice);

        return $this;
    }
}
