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
    private $allowedImageExtensions = array('jpg', 'jpeg', 'png');

    /**
     * @var string
     */
    private $name;

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
        if ($name !== '' ) {
            $path = Mage::getBaseDir('media') . DS . self::IMAGES_MAIN_DIR . DS . $type . DS . $name;
        } 

        return $path;
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
        if ($name !== '') {
            $path = Mage::getBaseUrl('media') . self::IMAGES_MAIN_DIR . DS . $type . DS . $name;
        }
        
        return $path;
    }

    /**
     * Image size validation
     *
     * @param $image
     * @return bool
     */
    public function validateImageSize($image)
    {
        $validation = true;

        if (getimagesize($image)[0] < 800 || getimagesize($image)[1] < 800) {
            $validation = false;
        }

        return $validation;
    }

    /**
     * Crop images
     *
     * @param array $gridCoords
     * @param array $listCoords
     * @param string $fileExtension
     */
    public function cropImages(array $gridCoords, array $listCoords)
    {
        $fileManager = new Varien_Io_File();
        $gridDirName = $this->getImagePath('grid');
        $listDirName = $this->getImagePath('list');


        if (!is_dir($gridDirName)) {
            $fileManager->mkdir($gridDirName);
        }

        if (!is_dir($listDirName)) {
            $fileManager->mkdir($listDirName);
        }

        $image = $this->getTmpImagePath();
        $fileExtension = $this->getImgExtension();
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
    public function getTmpImage()
    {

        $image = false;
        $dirFiles =  scandir(Mage::getBaseDir('media') . DS .self::IMAGES_MAIN_DIR . DS . 'tmp' . DS);

        foreach ($dirFiles as $file) {
            if (strpos($file, 'file' ) !== null){
                $image = $file;
            }
        }

        return $image;
    }

    /**
     * Get tmp image path
     *
     * @return string
     */
    public function getTmpImagePath()
    {
        return Mage::getBaseDir('media') . DS .     self::IMAGES_MAIN_DIR . DS . 'tmp'. DS . $this->getTmpImage();
    }

    /**
     * Get image extension
     *
     * @return string
     */
    public function getImgExtension()
    {
        return substr(stristr($this->getTmpImage(),"."), 1);
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
     */
    public function saveFinal($postData)
    {
        if ($postData['gridx'] != ''){
            try {
                $this->cropImages($this->prepareCoords('grid', $postData), $this->prepareCoords(   'list', $postData));

                if($this->validateImageRatio('list') == false || $this->validateImageRatio('grid') == false) {
                    unlink($this->getImagePath('grid', $this->getName()));
                    unlink($this->getImagePath('list', $this->getName()));
                    Mage::getSingleton('core/session')->addError('Image was not saved because of inapropriate ratio');
                    $_POST['parameters']['image'] = null;
                }
                unlink($this->getTmpImagePath());
            } catch (Exception $e) {
                $e->getMessage();
            }
        }
    }

    /**
     * Convert ration to int
     *
     * @param $ratio
     * @return float
     */
    public function convertRatio($ratio)
    {
        $result = explode('/', $ratio);
        return round($result[0]/$result[1],PHP_ROUND_HALF_UP);
    }

    /**
     * Image ratio validation
     *
     * @param $type
     * @param $image
     * @return bool
     * @throws Mage_Core_Model_Store_Exception
     */
    public function validateImageRatio($type, $image)
    {
        $validation = true;
        $requiredGridRatio = $this->convertRatio(Mage::getStoreConfig('sapiha_banner/sapiha_banner_group/grid_image_ratio', Mage::app()->getStore()));
        $requiredListRatio = $this->convertRatio(Mage::getStoreConfig('sapiha_banner/sapiha_banner_group/list_image_ratio', Mage::app()->getStore()));

        if ($type == 'list' && round(getimagesize($image)[0] / getimagesize($image)[1], PHP_ROUND_HALF_UP) != $requiredListRatio) {
            $validation = false;
        }

        if ($type == 'grid' && round(getimagesize($image)[0] / getimagesize($image)[1], PHP_ROUND_HALF_UP) != $requiredGridRatio) {
            $validation = false;
        }

        return $validation;
    }
}
