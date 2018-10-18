<?php

class Sapiha_Banner_IndexController extends Mage_Core_Controller_Front_Action
{
    /**
     * Update banner clicks amount action
     *
     * @return void
     * @throws Varien_Exception
     */
    public function updateClickAction()
    {
        $id = (int)$this->getRequest()->getParam('id');
        $model = Mage::getModel('sapiha_banner/banner')->load($id, 'banner_id');

        if ($model->getId() != null) {
            $clickAmount = $model->getClickCount();
            $clickAmount++;
            $model->setId($model->getId())->setClickCount($clickAmount);
        } else {
            $model->setData('banner_id', $id );
            $model->setData('click_count', 1);
        }

        try {
            $model->save();
        } catch (Exception $e) {
            Mage::logException($e);
            $this->_getSession()->addError($e->getMessage());
        }
    }
}
