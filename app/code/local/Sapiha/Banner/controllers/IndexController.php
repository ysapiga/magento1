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
        $model = Mage::getModel('sapiha_banner/banner');
        $id = (int)$this->getRequest()->getParam('id');
        $modelId =  $model->getResource()->getIdByWidgetId($id);

        if ( $modelId != null) {

            try{
                $model->load($modelId);
                $clickAmount = $model->getClickCount();
                $clickAmount++;
                $model->setId($model->getId())->setClickCount($clickAmount)->save();

            } catch (Exception $e) {
                Mage::logException($e);
                $this->_getSession()->addError($e->getMessage());
            }
        } else {
            $model->setData('banner_id', $id );
            $model->setData('click_count', 1);
            $model->save();
        }
    }
}
