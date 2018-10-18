<?php

class Sapiha_Banner_Model_Image_Processor extends Mage_Core_Model_Abstract
{
    /**
     * @var Sapiha_Banner_Model_Image
     */
    private $image;

    /**
     * @var array
     */
    private $allowedBannerTypes = ['grid', 'list'];

    public function __construct()
    {
        parent::__construct();
        $this->image = Mage::getModel('sapiha_banner/image');
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
     * Delete realted images
     *
     * @param string $name
     * @return void
     */
    public function deleteImages($name)
    {
        $image = $this->getImage();

        foreach ($this->getAllowedBannerTypes() as $type)
        {
            $image->deleteImageFile($type, $name);
        }
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
            $image->setForCropCoords($this->setCoords());

            try {
                foreach ($this->getAllowedBannerTypes() as $type) {
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
        return (array_key_exists($this->setCoords()[0], $postData) && $postData[$this->setCoords()[0]] !== '' );
    }

    /**
     * Generate coords for crop according to allowed types
     *
     * @return array
     */
    private function setCoords()
    {
        $coords = [];

        foreach ($this->allowedBannerTypes as $type)
        {
            foreach ($this->getImage()->getForCropCoords() as $coord) {
                $coords [] = $type . $coord;
            }
        }

        return $coords;
    }
}
