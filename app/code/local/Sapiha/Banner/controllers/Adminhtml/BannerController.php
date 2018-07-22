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
        $response = array();
        $helper = Mage::helper('sapiha_banner');
        $image = Mage::getModel('sapiha_banner/image');


        if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
            $uploader = new Varien_File_Uploader('image');
            $uploader->setFilesDispersion(false);
            $uploader->setAllowedExtensions($image->getAllowedImageExtensions());
            $uploader->setAllowRenameFiles(true);
            $image->setName('file.' . $uploader->getFileExtension());

            try {
                $uploader->save($image->getImagePath('tmp'), $image->getName());
                $uploadedFile = $image->getImageUrl('tmp', $image->getName());
                $response['result'] = true;
                $response['image'] = $uploadedFile;
                $imagePath = $image->getImagePath('tmp', $image->getName());

                if($image->validateImageSize($imagePath) == false)   {
                    unlink($image->getImagePath('tmp',$image->getName()));
                    $this->_getSession()->addError('Small image');
                    $response['result'] = false;
                    $respone['image'] = "";
                    $response['error'] = $helper->__('Small Image');
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
