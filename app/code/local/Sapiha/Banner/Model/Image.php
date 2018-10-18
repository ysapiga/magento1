<?php

class Sapiha_Banner_Model_Image extends Mage_Core_Model_Abstract
{
    /**
     * Banners images folder
     *
     * @var string
     */
    const IMAGES_MAIN_DIR = 'sapiha_banner';

    /**
     * @var array
     */
    private $allowedImageExtensions = ['jpg', 'jpeg', 'png'];

    /**
     * Required croop coords
     *
     * @var array
     */
    private $forCropCoords = ['x', 'y', 'width', 'height'];

    /**
     * Get required coords
     *
     * @return array
     */
    public function getForCropCoords()
    {
        return $this->forCropCoords;
    }

    /**
     * Set coords
     *
     * @param array $coords
     * @return void
     */
    public function setForCropCoords(array $coords)
    {
        $this->forCropCoords = $coords;
    }

    /**
     * Get allowed image extensions
     *
     * @return array
     */
    public function getAllowedImageExtensions()
    {
        return $this->allowedImageExtensions;
    }

    /**
     * Get image path by type
     *
     * @param string $type
     * @param string $name
     * @return string
     */
    public function getImagePath($type, $name = '')
    {
        $path = Mage::getBaseDir('media') . DS . self::IMAGES_MAIN_DIR . DS . $type;

        return ($name == '') ? $path : $path . DS . $name;
    }

    /**
     * Get image url by type
     *
     * @param string $type
     * @param string $name
     * @return string
     */
    public function getShortImagePath($type, $name = '')
    {
        $path = self::IMAGES_MAIN_DIR . DS . $type;

        return ($name == '') ? $path : $path . DS . $name;
    }

    /**
     * Image size validation
     *
     * @param string $image
     * @return bool
     */
    public function validateImageSize($image)
    {
        return !(getimagesize($image)[0] < 800 || getimagesize($image)[1] < 800);
    }
    /**
     * Save cropped images
     *
     * @param array $postData
     * @param string $imageName
     * @param string $type
     * @return void
     */
    public function saveFinal($postData, $imageName, $type)
    {
        try {
            $this->cropImages($this->prepareCoords($postData, $type), $imageName, $type);
        } catch (Exception $e) {
            $e->getMessage();
        }
    }

    /**
     * Delete image
     *
     * @param string $type
     * @param string $name
     * @return void
     */
    public function deleteImageFile($type, $name)
    {
        try {
            unlink($this->getImagePath($type) . DS . $name);
        } catch (Exception $e) {
            Mage::logException($e);
        }
    }

    /**
     * Crop images
     *
     * @param array $coords
     * @param string $tmpImageName
     * @param $type
     * @return void
     */
    private function cropImages(array $coords, $tmpImageName, $type)
    {
        $fileManager = new Varien_Io_File();
        $dirName = $this->getImagePath($type);

        if (!is_dir($dirName)) {
            $fileManager->mkdir($dirName);
        }

        $image = $this->getImagePath('tmp', $tmpImageName);
        $this->setName($tmpImageName);
        $fileExtension = $this->getImgExtension($tmpImageName);

        if ($fileExtension == 'png') {
            $im = imagecreatefrompng($image);
            $croppedImg = imagecrop($im, $coords);
            imagepng($croppedImg, $this->getImagePath($type, $tmpImageName));
        } elseif ($fileExtension == 'jpeg' || $fileExtension == 'jpg') {
            $im = imagecreatefromjpeg($image);
            $croppedListImg = imagecrop($im, $coords);
            imagejpeg($croppedListImg, $this->getImagePath($type, $tmpImageName));
        }
    }

    /**
     * Get image extension
     *
     * @param string $imageName
     * @return string
     */
    private function getImgExtension($imageName)
    {
        return substr(stristr($imageName, "."), 1);
    }

    /**
     * Prepare coordinates before cropping
     *
     * @param array $postData
     * @param string $type
     * @return array
     */
    private function prepareCoords($postData, $type)
    {
        $result = [];

        foreach ($postData as $key =>$element) {
            if (in_array($key, $this->getForCropCoords()) && strpos($key, $type) !== false) {
                $result [str_replace($type, '', $key)] = $element;
            }
        }

        return $result;
    }
}
