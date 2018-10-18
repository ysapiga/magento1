<?php

class Sapiha_Kasa_Adminhtml_KasaController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Init Kasa Payment grid
     *
     * @return void
     */
    public function IndexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('sapiha_kasa');
        $this->renderLayout();
    }

    /**
     * Export data to csv file
     *
     * @return void
     * @throws Varien_Exception
     */
    public function exportCsvAction()
    {
        $fileName ='looted_coins.csv';
        $grid = $this->getLayout()->createBlock('sapiha_kasa/adminhtml_kasa_grid');
        try{
            $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
        } catch (Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        }
    }

    /**
     * @inheritdoc
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('asg_kasa');
    }
}
