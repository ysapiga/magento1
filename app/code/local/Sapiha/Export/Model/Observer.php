<?php

class Sapiha_Export_Model_Observer
{
    public function exportByCron()
    {
        $collection = Mage::getModel('sapiha_export/export')->getCollection()
            ->addFieldToFilter('is_active', 1);

        foreach ($collection as $export) {
            Mage::helper('sapiha_export')->export($export->getId());
        }
    }
}
