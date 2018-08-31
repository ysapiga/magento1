<?php

class Sapiha_Banner_Model_Image_Processor extends Mage_Core_Model_Abstract
{
    /**
     * @var Sapiha_Banner_Model_Image
     */
    public $image;

    /**
     * @var array
     */
    public $allowedBannerTypes = ['grid', 'list'];

    public function deleteImages($name)
    {
        $image = $this->getImage();

        foreach ($this->getAllowedBannerTypes() as $type)
        {
            $image->deleteImageFile($type, $name);
        }
    }

    /**
     * Sapiha_Banner_Model_Image_Processor constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->image = Mage::getModel('sapiha_banner/image');
    }

    /**
     * Returns array of allowed Banner types
     *
     * @return array
     */
    public function getAllowedBannerTypes()
    {
        return $this->allowedBannerTypes;
    }

    /**
     * Returns image object
     *
     * @return Sapiha_Banner_Model_Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Generate coords for crop according to allowed types
     *
     * @return array
     */
    public function coordsFactory()
    {
        $coords = [];

        foreach ($this->allowedBannerTypes as $type)
        {
            foreach ($this->getImage()->getForCropCoords() as $coord)
            {
                $coords [] = $type . $coord;
            }
        }

        return $coords;
    }

    /**
     * Save cropped images
     *
     * @param array $postData
     * @return bool
     */
    public function processSave($postData)
    {
        $success = false;

        if($this->isNeedBeSaved($postData)){
            $image = $this->getImage();
            $image->setForCropCoords($this->coordsFactory());

            try {
                foreach ($this->getAllowedBannerTypes() as $type)
                    {
                        $image->saveFinal($postData, $this->getTmpImage(), $type);
                    }
                $success = true;
                $image->deleteImageFile('tmp', $this->getTmpImage());

            } catch (Exception $e) {
                Mage::logException($e);
            }
        }

        return $success;
    }

    /**
     * Get tmp banner image
     *
     * @return string
     * @throws Varien_Exception
     */
    public function getTmpImage()
    {
        return Mage::getSingleton('adminhtml/session')->getTmpImageName();
    }

    /**
     * @param array $postData
     * @return bool
     */
    public function isNeedBeSaved($postData)
    {
        return (array_key_exists($this->coordsFactory()[0], $postData) && $postData[$this->coordsFactory()[0]] !== '' );
    }
}
