<?php

class Sapiha_Banner_Model_Image extends Mage_Core_Model_Abstract
{
    /**
     * Banners images folder
     * @var string
     */
    const IMAGES_MAIN_DIR = 'sapiha_banner';
    /**
     * @var array
     */
    private $allowedImageExtensions = ['jpg', 'jpeg', 'png'];

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
    public function getImageUrl($type, $name = '')
    {

        $path = Mage::getBaseUrl('media') . self::IMAGES_MAIN_DIR . DS . $type;

        return ($name == '') ? $path : $path . DS . $name;
    }

    /**
     * Image size validation
     *
     * @param $image
     * @return bool
     */
    public function validateImageSize($image)
    {
        return !(getimagesize($image)[0] < 800 || getimagesize($image)[1] < 800);
    }

    /**
     * Crop images
     *
     * @param array $gridCoords
     * @param array $listCoords
     * @param string $fileExtension
     * @return void
     */
    public function cropImages(array $gridCoords, array $listCoords)
    {
        $fileManager = new Varien_Io_File();
        $gridDirName = $this->getImagePath('grid');
        $listDirName = $this->getImagePath('list');
        $tmpImageName = Mage::getSingleton('adminhtml/session')->getTmpImageName();


        if (!is_dir($gridDirName)) {
            $fileManager->mkdir($gridDirName);
        }

        if (!is_dir($listDirName)) {
            $fileManager->mkdir($listDirName);
        }

        $image = $this->getTmpImagePath($tmpImageName);
        $fileExtension = $this->getImgExtension($tmpImageName);
        $newImageName = Mage::helper('core')->uniqHash() . '.' . $fileExtension;
        $this->setName($newImageName);

        if ($fileExtension =='png') {
            $im = imagecreatefrompng($image);
            $croppedListImg = imagecrop($im, $listCoords);
            $croppedGridImg = imagecrop($im, $gridCoords);
            imagepng($croppedGridImg, $this->getImagePath('grid', $newImageName));
            imagepng($croppedListImg, $this->getImagePath('list', $newImageName));
        } elseif ($fileExtension =='jpeg' || $fileExtension =='jpg' ) {
            $im = imagecreatefromjpeg($image);
            $croppedListImg = imagecrop($im, $listCoords);
            $croppedGridImg = imagecrop($im, $gridCoords);
            imagejpeg($croppedGridImg, $this->getImagePath('grid', $newImageName));
            imagejpeg($croppedListImg, $this->getImagePath('list', $newImageName));
        }
    }

    /**
     * Get tmp image filename
     *
     * @return string
     */
    public function getTmpImage($instanceId)
    {
        $image = false;
        $dirFiles =  scandir(Mage::getBaseDir('media') . DS .self::IMAGES_MAIN_DIR . DS . 'tmp' . DS);

        foreach ($dirFiles as $file) {
            if (strpos($file, $instanceId ) !== false){
                $image = $file;
                break;
            }
        }

        return $image;
    }

    /**
     * Get tmp image path
     *
     * @return string
     */
    public function getTmpImagePath($instanceId)
    {
        return Mage::getBaseDir('media') . DS . self::IMAGES_MAIN_DIR . DS . 'tmp'. DS . $this->getTmpImage($instanceId);
    }

    /**
     * Get image extension
     *
     * @return string
     */
    public function getImgExtension($instanceId)
    {
        return substr(stristr($this->getTmpImage($instanceId), "."), 1);
    }

    /**
     * Prepare coordinates before cropping
     *
     * @param sting $type
     * @param array $postData
     * @return array
     */
    public function prepareCoords($type, $postData)
    {
        $result = [];

        foreach ($postData as $key =>$element) {
            if(strpos($key, $type) !== false){
                $result [substr($key, 4)] = $element;
            } else if ($key == 'instance_id') {
                $result ['instance_id'] = $element ;
            }
        }

        return $result;
    }

    /**
     * Save cropped images
     *
     * @param $postData
     * @param $fileExtension
     * @return void
     */
    public function saveFinal($postData)
    {
        if ($postData['gridx'] != ''){

            try {
                $this->cropImages($this->prepareCoords('grid', $postData), $this->prepareCoords(   'list', $postData));
                $tmpImageName = Mage::getSingleton('adminhtml/session')->getTmpImageName();
                unlink($this->getTmpImagePath($tmpImageName));

            } catch (Exception $e) {
                $e->getMessage();
            }
        }
    }
}
