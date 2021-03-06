<?php

class Sapiha_Banner_Adminhtml_BannerController extends Mage_Adminhtml_Controller_Action
{
    /**
     * upload tmp image action
     *
     * @return void
     * @throws Exception
     */
    public function uploadAction()
    {
        $response = [];
        $helper = Mage::helper('sapiha_banner');
        $image = Mage::getModel('sapiha_banner/image');

        if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
            $name = Mage::helper('core')->uniqHash();
            $uploader = new Varien_File_Uploader('image');
            $uploader->setFilesDispersion(false);
            $uploader->setAllowedExtensions($image->getAllowedImageExtensions());
            $uploader->setAllowRenameFiles(true);
            $image->setName("$name." . $uploader->getFileExtension());
            Mage::getSingleton('adminhtml/session')->setTmpImageName($image->getName());

            try {
                $uploader->save($image->getImagePath('tmp'), $image->getName());
                $uploadedFile = Mage::getBaseUrl('media') . $image->getShortImagePath('tmp', $image->getName());
                $response['result'] = true;
                $response['image'] = $uploadedFile;
                $imagePath = $image->getImagePath('tmp', $image->getName());

                if($image->validateImageSize($imagePath) == false)   {
                    unlink($image->getImagePath('tmp',$image->getName()));
                    $response['result'] = false;
                    $respone['image'] = "";
                    $response['error'] = $helper->__('The Image is too small, please chose an image with size at least 800*800px');
                }

            } catch (Exception $e) {
                $response['result'] = false;
                $response['error'] = $helper->__('Invalid File Type');
            }

        } else {
            $response['result'] = false;
            $response['error'] = $helper->__('Empty request');
        }
        $this->getResponse()->setBody(
            Mage::helper('core')->jsonEncode($response)
        );
    }
}
