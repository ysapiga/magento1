<?php

class Sapiha_Starshipment_Model_Carrier extends Mage_Shipping_Model_Carrier_Abstract
    implements Mage_Shipping_Model_Carrier_Interface
{
    /**
     * @var string
     */
    protected $_code = 'sapiha_starshipment';

    const FIRST_METHOD = 'to_long';
    const SECOND_METHOD = 'faster_than_long';
    const THIRD_METHOD = 'teleport';

    /**
     * Collect Shipping rates
     *
     * @param Mage_Shipping_Model_Rate_Request $request
     * @return Mage_Shipping_Model_Rate_Result
     */
    public function collectRates(Mage_Shipping_Model_Rate_Request $request)
    {
        $result = Mage::getModel('shipping/rate_result');
        $result->append($this->_getFirstRate());
        $result->append($this->_getSecondtRate($request));
        $result->append($this->_getThirdRate($request));

        return $result;
    }

    /**
     * Get Allowed shipping methods
     *
     * @return array
     */
    public function getAllowedMethods()
    {
        return [
            self::FIRST_METHOD,
            self::SECOND_METHOD,
            self::THIRD_METHOD,
        ];
    }

    /**
     * Get first shipping rate
     *
     * @return Mage_Core_Model_Abstract
     */
    protected function _getFirstRate()
    {
        $helper = Mage::helper('sapiha_starshipment');
        $rate = Mage::getModel('shipping/rate_result_method');
        $rate->setCarrier($this->_code);
        $rate->setCarrierTitle($this->getConfigData('title'));
        $rate->setMethod(self::FIRST_METHOD);
        $rate->setMethodTitle($helper->__('Standard delivery  (5 - 10 days)'));
        $rate->setPrice(10);
        $rate->setCost(10);

        return $rate;
    }

    /**
     * Get second shipping rate
     *
     * @param $request
     * @return Mage_Core_Model_Abstract
     */
    protected function _getSecondtRate($request)
    {
        $helper = Mage::helper('sapiha_starshipment');
        $rate = Mage::getModel('shipping/rate_result_method');
        $rate->setCarrier($this->_code);
        $rate->setCarrierTitle($this->getConfigData('title'));
        $rate->setMethod(self::SECOND_METHOD);
        $rate->setMethodTitle($helper->__('Express delivery (less than 5 days)'));
        $rate->setPrice($this->_setSecondRatePrice($request));
        $rate->setCost($this->_setSecondRatePrice($request));

        return $rate;
    }

    /**
     * Get third shipping rate
     *
     * @param $request
     * @return Mage_Core_Model_Abstract
     */
    protected function _getThirdRate($request)
    {
        $helper = Mage::helper('sapiha_starshipment');
        $rate = Mage::getModel('shipping/rate_result_method');
        $rate->setCarrier($this->_code);
        $rate->setCarrierTitle($this->getConfigData('title'));
        $rate->setMethod(self::THIRD_METHOD);
        $rate->setMethodTitle($helper->__('Teleport  (less than 1 day)'));
        $rate->setPrice($this->_setThirdRatePrice($request));
        $rate->setCost($this->_setThirdRatePrice($request));

        return $rate;
    }

    /**
     * Calculate price for second rate
     *
     * @param $request
     * @return float|int
     */
    public function _setSecondRatePrice($request)
    {
        $cartAmount = $request->getPackageValueWithDiscount();
        $percent = 0.05;
        if (count($request->getAllItems()) > 2) {
            $percent = $percent + 0.02;
        }
        if (Mage::getModel('core/date')->date('N') > 5){
            $percent = $percent + 0.03;
        }

        $price = $cartAmount * $percent;
        return $price;
    }

    /**
     * Calculate price for third rate
     *
     * @param $request
     * @return float|int
     */
    public function _setThirdRatePrice($request)
    {
        $cartAmount = $request->getPackageValueWithDiscount();

        if ($cartAmount<50) {
            $price = 10;
        }
        if ($cartAmount<100 && $cartAmount>50) {
            $price =(int) $cartAmount * 0.15;
        }
        if($cartAmount<1000 && $cartAmount>100) {
            $price =(int) $cartAmount * 0.05;
        }
        if($cartAmount>1000) {
            $price = 0;
        }

        return $price;
    }

    public function isTrackingAvailable()
    {
        return false;
    }
}
