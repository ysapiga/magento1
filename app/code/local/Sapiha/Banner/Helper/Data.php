<?php

class Sapiha_Banner_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * @var array
     */
    private $allowedImageExtensions = array('jpg', 'jpeg', 'png');

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
     * Get path to selected image
     *
     * @param $type
     * @param string $filename
     * @return string
     */
    public function getImagePath($type, $filename = '')
    {
        if(isset($filename)) {
            $path = Mage::getBaseDir('media') . DS . 'sapiha_banner' . DS . $type . DS . $filename;
        } else {
            $path = Mage::getBaseDir('media') . DS . 'sapiha_banner' . DS . $type . DS ;
        }

        return $path;
    }

    /**
     * Get selected image url
     *
     * @param $type
     * @param string $fileName
     * @return string
     */
    public function getImageUrl($type, $fileName = '')
    {
        return Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . 'sapiha_banner'. DS . $type . DS . $fileName;
    }

    /**
     * Crop images
     *
     * @param array $gridCoords
     * @param array $listCoords
     * @param string $fileExtension
     */
    public function cropImages(array $gridCoords, array $listCoords, $fileExtension)
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

        $id = $gridCoords['instance_id'];
        $image = $this->getImagePath('tmp', "file.$fileExtension");

        if ($fileExtension =='png') {
            $im = imagecreatefrompng($image);
            $croppedListImg = imagecrop($im, $listCoords);
            $croppedGridImg = imagecrop($im, $gridCoords);
            imagepng($croppedGridImg, $this->getImagePath('grid', "$id.$fileExtension"));
            imagepng($croppedListImg, $this->getImagePath('list', "$id.$fileExtension"));
        } elseif ($fileExtension =='jpeg' || $fileExtension =='jpg' ) {
            $im = imagecreatefromjpeg($image);
            $croppedListImg = imagecrop($im, $listCoords);
            $croppedGridImg = imagecrop($im, $gridCoords);
            imagejpeg($croppedGridImg,$this->getImagePath('grid', "$id.$fileExtension"));
            imagejpeg($croppedListImg,$this->getImagePath('list', "$id.$fileExtension"));
        }
    }

    /**
     * Sort post data before cropping
     *
     * @param sting $type
     * @param array $postData
     * @return array
     */
    public function sortPostData($type, $postData)
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
    public function saveFinalImages($postData, $fileExtension)
    {
        if ($postData['gridx'] != ''){
            try {
                $this->cropImages($this->sortPostData('grid', $postData), $this->sortPostData('list', $postData), $fileExtension);

                if($this->validateImageRatio('list', $this->getImagePath('list',$postData['instance_id'] .'.'. $fileExtension)) == false) {
                    unlink($this->getImagePath('list', $postData['instance_id']));
                    Mage::getSingleton('core/session')->addError('Image was not saved because of inapropriate ratio');
                }
                unlink($this->getImagePath('tmp', "file.$fileExtension"));
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

    public function validateMaxPosition($positionList, $positionGrid)
    {
        $validation = true;
        $maxGridPosition = (int) Mage::getStoreConfig('catalog/frontend/grid_per_page', Mage::app()->getStore()) * 3;
        $maxListPosition = (int) Mage::getStoreConfig('catalog/frontend/list_per_page', Mage::app()->getStore()) * 3;

        if($positionList > $maxListPosition || $positionGrid > $maxGridPosition) {
            $validation = false;
        }

       return $validation;
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

        if (getimagesize($image)[0] < 300 || getimagesize($image)[1] < 300) {
            $validation = false;
        }

        return $validation;
    }


    /**
     * Convert image array to string
     *
     * @param array $arr
     * @return array
     */
    public function imageArrayToString(array $arr)
    {
        if (isset( $arr['image'] ['value'])) {
            $arr['image'] = $arr['image'] ['value'];
        }

        return $arr;
    }
}
