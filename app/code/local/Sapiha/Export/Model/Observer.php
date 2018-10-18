<?php

class Sapiha_Export_Model_Observer
{
    /**
     * Generation export files by Cron
     *
     * @return void
     */
    public function exportByCron()
    {
        $collection = Mage::getModel('sapiha_export/export')->getCollection()
            ->addFieldToFilter('is_active', 1);

        foreach ($collection as $export) {
            Mage::helper('sapiha_export')->export($export->getId());
        }
    }
}
