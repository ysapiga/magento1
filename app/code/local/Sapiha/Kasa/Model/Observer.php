<?php

class Sapiha_Kasa_Model_Observer
{
    /**
     * Save looted coins
     *
     * @param $observer
     * @return void
     */
    public function writeOrder($observer)
    {
        if ($observer->getOrder()->getPayment()->getMethod() == Sapiha_Kasa_Model_Method::CODE) {

            try{
                $kasaCommision = $observer->getQuote()->getShippingAddress()->getCustomDiscount();
                $model = Mage::getModel('sapiha_kasa/robberyorder');
                $orderId = $observer->getEvent()->getOrder()->getId();
                $coins = $observer->getQuote()->getShippingAddress()->getLootedCoins();
                $model->setRobberyAmount($coins);
                $model->setKasaPercent($kasaCommision);
                $model->setOrderId((int)$orderId);
                $model->save();

            } catch (Exception $e) {
                Mage::logException($e);
            }
        }
    }

    /**
     * Allow Kasa Payment
     *
     * @param $observer
     * @return void
     */
    public function allowPayment($observer)
    {
        $result = $observer->getData('result');
        $quote = $observer->getQuote();

        if ($quote !== null) {
           $shippingMethod = $quote->getShippingAddress()->getShippingMethod();
        }

        if ($observer->getEvent()->getMethodInstance()->getCode() == Sapiha_Kasa_Model_Method::CODE && $shippingMethod == 'sapiha_starshipment_faster_than_long'){
               $result->isAvailable = true;
        } elseif ($observer->getEvent()->getMethodInstance()->getCode() == Sapiha_Kasa_Model_Method::CODE) {
            $result->isAvailable = false;
        }
    }
}
