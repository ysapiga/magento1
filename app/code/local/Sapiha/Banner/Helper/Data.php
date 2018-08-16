<?php

class Sapiha_Banner_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Get last inserted widget instance id
     *
     * @return string
     */
    public function getWidgetIncrementId()
    {
        $result = Mage::getSingleton('core/resource')->getConnection('core_read')->showTableStatus('widget_instance');
        return $result['Auto_increment'];
    }
}
