<?php

class Sapiha_Kasa_Model_Invoice_Total extends Mage_Sales_Model_Order_Invoice_Total_Abstract
{
    /**
     * Collect totals on invoice action
     *
     * @param Mage_Sales_Model_Order_Invoice $address
     * @return $this|Mage_Sales_Model_Order_Invoice_Total_Abstract
     */
    public function collect(Mage_Sales_Model_Order_Invoice $invoice)
    {
        $subtotal = $invoice ->getOrder()->getBaseSubtotal();
        $baseDiscount = $invoice->getOrder()->getBaseDiscountAmount();
        $taxAmount = $invoice->getOrder()->getBaseTaxAmount();
        $shippingAmount = $invoice->getOrder()->getShippingAmount();
        $kasaComision = $subtotal * 0.03;
        $finalPrice = $subtotal + $kasaComision + $baseDiscount + $taxAmount + $shippingAmount;

        if (filter_var($finalPrice, FILTER_VALIDATE_INT)) {
            $lootedCoins = 1;
            $finalPrice = $finalPrice + $lootedCoins;
        } else {
            $lootedCoins = ceil($finalPrice) - $finalPrice;
            $finalPrice = ceil($finalPrice);
        }

        $invoice->setLootedCoins($lootedCoins);
        $invoice->setCustomDiscount($kasaComision);
        $invoice->setGrandTotal($finalPrice);

        return $this;
    }
}
