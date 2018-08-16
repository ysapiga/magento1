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
            $image = Mage::getModel('sapiha_banner/image');
            unlink($image->getImagePath('grid') . DS . $imageName);
            unlink($image->getImagePath('list') . DS . $imageName);
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
        if($observer->getObject()->getData('type') == self::BANNER_TYPE) {
            $helper = Mage::helper('sapiha_banner');
            $widgetParameters = $observer->getObject()->getWidgetParameters();
            $post = $_POST;
            $image = Mage::getModel('sapiha_banner/image');
            $widgetInstance = $observer->getDataObject();

            if ($widgetInstance->getId() > 0) {
                $widgetParameters ['image'] = unserialize($observer->getObject()->getOrigData('widget_parameters'))['image'];
                $post['parameters']['instance_id'] = $widgetInstance->getId();
            } else {
                $widgetParameters['instance_id'] = $helper->getWidgetIncrementId();
                $post['parameters']['instance_id'] = $helper->getWidgetIncrementId();
            }

            if ($post['gridx'] !== "") {
                $widgetParameters['image'] = $image->getImageUrl('grid', $image->getTmpImage($widgetParameters['instance_id']));
                $image->saveFinal($post);
                if ($widgetParameters['image'] !== null) {
                    $widgetParameters['image'] = $image->getImageUrl('grid', $image->getName());
                }
            } elseif ($widgetParameters['image'] == '') {
                $widgetParameters['is_active'] = '0';
            }
            $widgetInstance->setSortOrder($post['sort_order'], 0)
                ->setWidgetParameters(serialize($widgetParameters));
        }
    }
}
