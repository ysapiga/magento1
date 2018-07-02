<?php

class Sapiha_Export_Adminhtml_ExportController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Display grid of exports
     *
     * @return void
     */
    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('sapiha_export');
        $this->renderLayout();
    }

    /**
     * editAction for export entity
     *
     * @return void
     */
    public function editAction()
    {
        $id = (int)$this->getRequest()->getParam('id');
        $model = Mage::getModel('sapiha_export/export')->load($id);
        Mage::register('current_export', $model);
        $this->loadLayout();
        $this->_setActiveMenu('sapiha_export');
        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
        $this->renderLayout();
    }

    /**
     * Get categories fieldset block
     *
     * @return void
     */
    public function categoriesAction()
    {
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('sapiha_export/export')->load($id);
        Mage::register('current_export', $model);
        $this->loadLayout();
        $this->renderLayout();
    }

    public function categoriesJsonAction()
    {
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('sapiha_export/export')->load($id);
        Mage::register('current_export', $model);
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('sapiha_export/adminhtml_export_edit_tabs_category')
                ->getCategoryChildrenJson($this->getRequest()->getParam('category'))
        );
    }

    /**
     * @return void
     */
    public function newAction()
    {
       $this->_forward('edit');
    }

    /**
     * Save export entity item
     *
     * @return void
     * @throws Exception
     */
    public function saveAction()
    {
        $model = Mage::getModel('sapiha_export/export');

        if ($id = $this->getRequest()->getParam('id')) {
            $post = $this->getRequest()->getPost();
            $model->setData($post)->setId($id)->save();
            $this->_redirect('*/*/index');
            $this->_getSession()->addSuccess('The export was successfully updated');
        } elseif ($post = $this->getRequest()->getPost()) {
            $model->setData($post);
            $model->save();
            $this->_redirect('*/*/index');
            $this->_getSession()->addSuccess('The export was successfully created');
        }
    }

    /**
     * Action for export file creation
     *
     * @return void
     */
    public function exportAction ()
    {
        $helper = Mage::helper('sapiha_export');
        $id = $this->getRequest()->getParam('id');
        $helper->export($id);
        $this->_redirect('*/*/index');
    }

    /**
     * massAction for export file creations
     *
     * @return void
     */
    public function massExportAction()
    {
        $exports = $this->getRequest()->getParam('export', null);
        $helper = Mage::helper('sapiha_export');

        if (is_array($exports) && sizeof($exports) > 0) {
                    $helper->massExport($exports);
        } else {
            $this->_getSession()->addError($this->__('Please select Export'));
        }
        $this->_redirect('*/*');
    }

    /**
     * Delete export entity
     *
     * @return void
     * @throws Exception
     */
    public function deleteAction()
    {
        $id = $this->getRequest()->getParam('id');
        Mage::getModel('sapiha_export/export')->setId($id)->delete();
        $this->_redirect('*/*/index');
        $this->_getSession()->addSuccess("The Export was successfully deleted");
    }

    /**
     * @return mixed
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('admin/sapiha_export');
    }
}
