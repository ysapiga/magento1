<?php

class Sapiha_Banner_Model_Observer
{
    /**
     * Delete related banner images
     *
     * @param Varien_Event_Observer $observer
     * @return void
     */
    public function deleteImages($observer)
    {
        $parameters = $observer->getObject()->getWidgetParameters();
        $imageName = substr(strrchr($parameters['image'], '/'), 1)  ;
        $image = Mage::getModel('sapiha_banner/image');
        unlink($image->getImagePath('grid') . DS . $imageName);
        unlink($image->getImagePath('list') . DS . $imageName);
    }

    /**
     * Save banner
     *
     * @param Varien_Event_Observer $observer
     * @return void
     */
    public function saveBanner($observer)
    {
        $image = Mage::getModel('sapiha_banner/image');
        $helper = Mage::helper('sapiha_banner');
        $_POST = $helper->imageArrayToString($_POST);
        $widgetInstance = $observer->getDataObject();

        if ($helper->validateMaxPosition($_POST['parameters']['list_position'], $_POST['parameters']['grid_position'] )) {
            if ($widgetInstance->getId() > 0) {
                $_POST['parameters']['instance_id'] = $widgetInstance->getId();
            } else {
                $helper->getLastWidgetInsertId() + 1;
            }
            if ($_POST['gridx'] !== "") {
                $_POST['parameters']['image'] = $image->getImageUrl('grid', $image->getTmpImage());
                $image->saveFinal($_POST);
                if ($_POST['parameters']['image'] !== null) {
                    $_POST['parameters']['image'] = $image->getImageUrl('grid', $image->getName());

                }
            }
            $widgetInstance->setSortOrder($_POST['sort_order'], 0)
                ->setWidgetParameters(serialize($_POST['parameters']));
        } else {
            Mage::getSingleton('core/session')->addError('Banner Position is higher then required value, please chose new values');
            $_POST['parameters']['grid_position'] = '';
            $_POST['parameters']['list_position'] = '';
            $widgetInstance->setSortOrder($_POST['sort_order'], 0)
                ->setWidgetParameters(serialize($_POST['parameters']));
            Mage::app()->getResponse()->setRedirect(Mage::getUrl('*/*/edit'));
        }
    }
}
