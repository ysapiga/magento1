<?php

class Sapiha_Kasa_Model_Total extends Mage_Sales_Model_Quote_Address_Total_Abstract
{
    /**
     * Collect address total
     *
     * @param Mage_Sales_Model_Quote_Address $address
     * @return $this|Sapiha_Kasa_Model_Total
     */
    public function collect(Mage_Sales_Model_Quote_Address $address)
    {
        if (!$this->isActiveTotal($address)) {
            return $this;
        }

        $subtotal = $address->getBaseSubtotal();
        $baseDiscount = $address->getBaseDiscountAmount();
        $taxAmount = $address->getBaseTaxAmount();
        $shippingAmount = $address->getShippingAmount();
        $kasaComision = $subtotal * 0.03;
        $finalPrice = $subtotal + $kasaComision + $baseDiscount + $taxAmount + $shippingAmount;
        if (filter_var($finalPrice, FILTER_VALIDATE_INT)) {
            $lootedCoins = 1;
            $finalPrice = $finalPrice + $lootedCoins;
        } else {
            $lootedCoins = ceil($finalPrice) - $finalPrice;
            $finalPrice = ceil($finalPrice);
        }

        $address->setLootedCoins($lootedCoins);
        $address->setCustomDiscount($kasaComision);
        $address->setBaseGrandTotal($finalPrice);
        $address->setGrandTotal($finalPrice);
        Mage::unregister('looted_coins');
        Mage::register('looted_coins', $lootedCoins);

        return $this;
    }

    /**
     * Fetch Kasa comission
     *
     * @return void
     */
    public function fetch(Mage_Sales_Model_Quote_Address $address){
        $amount = $address->getCustomDiscount();
        if ($amount != 0) {
            $address->addTotal([
                'code' => $this->getCode(),
                'title' => Mage::helper('sapiha_kasa')->__('Kasa Comision'),
                'value' => $amount,
            ]);
        }
    }

    /**
     * Check collect total activation permission
     *
     * @param Mage_Sales_Model_Quote_Address $address
     * @return bool
     */
    private function isActiveTotal(Mage_Sales_Model_Quote_Address $address)
    {
        $result = true;
        $items = $this->_getAddressItems($address);
        if (!count($items)) {
            $result = false;
        }

        $quote = $address->getQuote();

        $shipping = $address->getShippingMethod();
        if(!$shipping) {
            $result = false;
        }

        $payment = $quote->getPayment();
        if(!$payment) {
            $result = false;
        }

        $paymentCode = $payment->getMethod();
        if(!$paymentCode || $paymentCode != 'sapiha_kasa') {
            $result = false;
        }

        return $result;
    }
}
