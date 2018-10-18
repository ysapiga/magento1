<?php

class Sapiha_News_IndexController extends Mage_Core_Controller_Front_Action
{
    /**
     * Display list of news
     *
     * @return void
     */
    public function newsListAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Display current news
     *
     * @return void
     */
    public function newsViewAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }
}
