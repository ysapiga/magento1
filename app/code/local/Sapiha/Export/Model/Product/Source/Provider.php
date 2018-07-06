<?php

class Sapiha_Export_Model_Product_Source_Provider extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
    /**
     * Retrieve All options
     *
     * @return array
     */
    public function getAllOptions()
    {
        $this->_options = array(
            array('value' => '', 'label' => 'Please Select'),
            array('value' => 'provider1', 'label' => 'Provider 1'),
            array('value' => 'provider2', 'label' => 'Provider 2'),
        );

        return $this->_options;
    }
}
