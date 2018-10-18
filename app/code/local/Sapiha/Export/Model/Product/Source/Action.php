<?php

class Sapiha_Export_Model_Product_Source_Action extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
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
            array('value' => 'yes', 'label' => 'Yes'),
            array('value' => 'no', 'label' => 'No'),
        );

        return $this->_options;
    }
}
