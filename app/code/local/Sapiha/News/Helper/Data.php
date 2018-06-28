<?php

class Sapiha_News_Helper_Data extends Mage_Core_Helper_Abstract
{

    /**
     * Get image folder path for news entity
     *
     * @param int $id
     * @return string
     */
    public function getImagePath($id = 0)
    {
        $path = Mage::getBaseDir('media') . '/sapiha_news';

        if ($id) {
            return "{$path}/{$id}.jpg";
        } else {
            return $path;
        }
    }

    /**
     * Get image media url for news entity
     *
     * @param int $id
     * @return string
     */
    public function getImageUrl($id = 0)
    {
        $url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . 'sapiha_news/';

        if ($id) {
            return $url . $id . '.jpg';
        } else {
            return $url;
        }
    }

    /**
     * Cut inserted text to smaller length
     *
     * @param string $text
     * @return string
     */
    public function cutText($text)
    {
        return substr($text,0,672)."...";
    }

    /**
     * Resize and save image into folder
     *
     * @param string $filePath
     * @param int $width
     * @param int $height
     * @return string
     */
    public function resizeImg($filePath, $width, $height)
    {
        $fileName = substr(strrchr($filePath, "/"),1);
        $folderURL = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA)."sapiha_news/";
        $imageURL = $folderURL . $fileName;
        $basePath = Mage::getBaseDir(Mage_Core_Model_Store::URL_TYPE_MEDIA) . DS.'sapiha_news'. DS. $fileName;
        $newPath = Mage::getBaseDir(Mage_Core_Model_Store::URL_TYPE_MEDIA) . DS .'sapiha_news'.DS.$width.'x'.$height.DS . $fileName;

        if ($width != '') {

            if (file_exists($basePath) && is_file($basePath) && !file_exists($newPath)) {
                $imageObj = new Varien_Image($basePath);
                $imageObj->constrainOnly(TRUE);
                $imageObj->keepAspectRatio(FALSE);
                $imageObj->keepFrame(FALSE);
                $imageObj->resize($width, $height);
                $imageObj->save($newPath);
            }

            $resizedURL = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA). 'sapiha_news/'.$width.'x'.$height."/". $fileName;
        } else {
            $resizedURL = $imageURL;
        }

        return $resizedURL;
    }

    /**
     * Upload and save file into module directory
     *
     * @param int $id
     * @throws Exception
     * @return void
     */
    public function uploadFile($id)
    {
        $uploader = new Varien_File_Uploader('image');
        $uploader->setAllowedExtensions(array('jpg', 'jpeg','png'));
        $uploader->setAllowRenameFiles(false);
        $uploader->setFilesDispersion(false);
        $uploader->save($this->getImagePath(), $id .'.jpg');
    }

    /**
     * Delete all related to entity files
     *
     * @param int $id
     * @param string $folderName
     * @param $folderName
     * @return void
     */
    public function deleteFiles($id, $folderName)
    {
        $fileName = "$id.jpg";
        $files = scandir($folderName);
        if(in_array($fileName, $files)) {
            @unlink($folderName.'/'.$fileName);
        }
        foreach ($files as $file) {
            if (is_dir($folderName.'/'  .$file) && $file !='.' && $file != '..'){
                $this->deleteFiles($id,$folderName.'/'.$file);
            }
        }
    }
}
