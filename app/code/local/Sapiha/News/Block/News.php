<?php

class Sapiha_News_Block_News extends Mage_Core_Block_Template
{
    /**
     * @inheritdoc
     */
    public function __construct()
    {
        parent::__construct();
        $collection = Mage::getModel("sapiha_news/news")->getCollection();
        $this->setCollection($collection);
    }

    /**
     * @inheritdoc
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $pager = $this->getLayout()->createBlock('page/html_pager', 'custom.pager');
        $limit = Mage::getStoreConfig('sapiha_news_options/list_options/count');
        $pager->setAvailableLimit(array($limit=>$limit));
        $pager->setCollection($this->getCollection());
        $this->setChild('pager', $pager);
        return $this;
    }

    /**
     * Convert pager block into html
     *
     * @return string
     */
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }

    /**
     * Get current news entity
     *
     * @return Sapiha_News_Model_News
     */
    public function getNews()
    {
        $model = Mage::getModel('sapiha_news/news');
        $id = $this->getRequest()->getParam('id');
        $model->load($id);
        return $model;
    }

}
