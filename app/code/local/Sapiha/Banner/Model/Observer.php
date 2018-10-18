<?php

class Sapiha_Banner_Model_Observer
{
    const BANNER_TYPE = "sapiha_banner/catalog_banner";

    /**
     * Delete related banner images
     *
     * @param Varien_Event_Observer $observer
     * @return void
     */
    public function deleteImages($observer)
    {
        if ($observer->getObject()->getData('type') == self::BANNER_TYPE) {
            $parameters = $observer->getObject()->getWidgetParameters();
            $imageName = substr(strrchr($parameters['image'], '/'), 1)  ;
            $imageProcessor = Mage::getModel('sapiha_banner/image_processor');
            $imageProcessor->deleteImages($imageName);
        }
    }

    /**
     * Save banner
     *
     * @param Varien_Event_Observer $observer
     * @return void
     */
    public function saveBanner($observer)
    {
        if ($observer->getObject()->getData('type') == self::BANNER_TYPE) {
            $widgetParameters = $observer->getObject()->getWidgetParameters();
            $post = Mage::app()->getRequest()->getPost();
            $imageProcessor = Mage::getModel('sapiha_banner/image_processor');
            $image = $imageProcessor->getImage();
            $widgetInstance = $observer->getDataObject();
            $tmpImageName = Mage::getSingleton('adminhtml/session')->getTmpImageName();

            if ($widgetInstance->getId() > 0) {
                $originParameters = unserialize($observer->getObject()->getOrigData('widget_parameters'));
                $widgetParameters ['image'] = $originParameters['image'];
                if (array_key_exists('imageList', $originParameters)) {
                    $widgetParameters['imageList'] =  unserialize($observer->getObject()->getOrigData('widget_parameters'))['imageList'];
                } else {
                    $widgetParameters['imageList'] = $image->getShortImagePath('list', $tmpImageName);
                }
            } else {
                $widgetParameters['instance_id'] = Mage::helper('sapiha_banner')->getWidgetIncrementId();
            }

            if ($imageProcessor->processSave($post)) {
                $widgetParameters['image'] = $image->getShortImagePath('grid', $tmpImageName);
                if ($widgetParameters['image'] !== null) {
                    $widgetParameters['image'] = $image->getShortImagePath('grid', $image->getName());
                    $widgetParameters['imageList'] = $image->getShortImagePath('list', $image->getName());
                }
            } elseif ($widgetParameters['image'] == '') {
                $widgetParameters['is_active'] = '0';
            }

            $widgetInstance->setSortOrder($post['sort_order'], 0)
                ->setWidgetParameters(serialize($widgetParameters));
        }
    }
}
