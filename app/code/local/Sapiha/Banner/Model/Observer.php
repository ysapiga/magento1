<?php

class Sapiha_Banner_Model_Observer
{
    /**
     * Delete banner related images
     *
     * @param $observer
     * @return void
     */
    public function deleteImages($observer)
    {
        $id = $observer->getEvent()->getObject()->getData('instance_id');
        $helper = Mage::helper('sapiha_banner');
        $gridDir = $helper->getImagePath('grid');
        $listDir = $helper->getImagePath('list');
        $gridDirFiles = scandir($gridDir);
        $listDirFiles = scandir($listDir);

        foreach ($gridDirFiles as $file) {
            if (stristr($file, '.', true) == $id) {
                unlink($gridDir . $file);
            }
        }
        foreach ($listDirFiles as $file) {
            if (stristr($file, '.', true) == $id) {
                unlink($listDir . $file);
            }
        }
    }
}
