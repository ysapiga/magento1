<?php

class Sapiha_Banner_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Convert image array to string
     *
     * @param array $arr
     * @return array
     */
    public function imageArrayToString(array $arr)
    {
        if (isset( $arr['parameters']['image'] ['value'])) {
            $arr['parameters']['image'] = $arr['parameters']['image'] ['value'];
        }

        return $arr;
    }

    /**
     * Max banner position validation
     *
     * @param int $positionList
     * @param int $positionGrid
     * @return bool
     * @throws Mage_Core_Model_Store_Exception
     */
    public function validateMaxPosition($positionList, $positionGrid)
    {
        $validation = true;
        $maxGridPosition = (int) Mage::getStoreConfig('catalog/frontend/grid_per_page', Mage::app()->getStore()) * 3;
        $maxListPosition = (int) Mage::getStoreConfig('catalog/frontend/list_per_page', Mage::app()->getStore()) * 3;

        if($positionList > $maxListPosition || $positionGrid > $maxGridPosition) {
            $validation = false;
        }

        return $validation;
    }

    /**
     * Get last inserted widget instance id
     *
     * @return string
     */
    public function getLastWidgetInsertId()
    {
        $db = Mage::getModel('core/resource')->getConnection('core_read');
        $result = $db->raw_fetchRow("SELECT MAX(`instance_id`) as LastID FROM `widget_instance`");

        return $result['LastID'];
    }
}
