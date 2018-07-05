<?php

class Sapiha_News_Adminhtml_NewsController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Display grid with news
     *
     * @return void
     */
    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('sapiha_news');
        $this->renderLayout();
    }

    /**
     * Redirect to editAction
     *
     * @return void
     */
    public function newAction()
    {
        $this->_forward('edit');
    }

    /**
     * Edit news entity
     *
     * @return void
     */
    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        //var_dump($this->getLayout()->getUpdate()->getHandles());
        if ($id) {
            $model = Mage::getModel('sapiha_news/news')->load($id);
            Mage::register('current_news', $model);
        }

        $this->loadLayout();
        $this->_setActiveMenu('sapiha_news');
        $this->renderLayout();
    }

    /**
     * Save news entity
     *
     * @return void
     */
    public function saveAction()
    {
        $helper = Mage::helper("sapiha_news");
        $model = Mage::getModel('sapiha_news/news');

        if ($id = $this->getRequest()->getParam('id')) {
            $postData = $this->getRequest()->getPost();
            if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
                $helper->uploadFile($id);
                $postData['image'] = $helper->getImageUrl($id);
            } elseif (isset($postData['image']['delete']) && $postData['image']['delete']=='1') {
                $helper->deleteFiles($id, 'media/sapiha_news');
                $postData['image'] = '';
            } elseif(isset( $postData['image'])) {
                $postData['image'] = array_shift($postData['image']);
            }

            $model->setData($postData);
            $model->setId($id)->save();
        } elseif ($this->getRequest()->getPost()) {
            $postData = $this->getRequest()->getPost();
            $model->setData($postData);
            $model->save();
            $id = $model->getId();
                if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
                    $helper->uploadFile($id);
                }
            $model->setImage($helper->getImageUrl($id))->save();
            }

            $this->_redirect('*/*/');
            $this->_getSession()->addSuccess($this->__("The News was successfully saved"));
    }

    /**
     * Delete news entity wit all related data
     *
     * @return void
     */
    public function deleteAction()
    {
        if ($id = $this->getRequest()->getParam('id')) {
            $helper = Mage::helper('sapiha_news');
            $helper->deleteFiles($id, 'media/sapiha_news');
            Mage::getModel('sapiha_news/news')->setId($id)->delete();
            $this->_getSession()->addSuccess($this->__("The News was successfully deleted"));
        }
        $this->_redirect('*/*/');
    }
}
