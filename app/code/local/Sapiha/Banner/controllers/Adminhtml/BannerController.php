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

        if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
            $uploader = new Varien_File_Uploader('image');
            $uploader->setFilesDispersion(false);
            $uploader->setAllowedExtensions($helper->getAllowedImageExtensions());
            $uploader->setAllowRenameFiles(true);
            $fileExtension = $uploader->getFileExtension();

            try {
                $uploader->save($helper->getImagePath('tmp'), "file.$fileExtension");
                $uploadedFile = $helper->getImageUrl('tmp', "file.$fileExtension");
                $response['result'] = true;
                $response['image'] = $uploadedFile;

                if($helper->validateImageSize($helper->getImagePath('tmp',"file.$fileExtension") == false)) {
                    unlink($helper->getImagePath('tmp',"file.$fileExtension"));
                    $this->_getSession()->addError('Small image');
                    $response['result'] = false;
                    $response['image'] = "";
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
