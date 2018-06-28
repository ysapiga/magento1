<?php

class Sapiha_News_Model_News extends Mage_Core_Model_Abstract
{
    /**
     * @inheritdoc
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('sapiha_news/news');
    }

    /**
     * Get image url for current news entity
     *
     * @return null|string
     */
    public function getImageUrl()
    {
        $helper = Mage::helper('sapiha_news');
        if ($this->getId() && file_exists($helper->getImagePath($this->getId()))) {
            return $helper->getImageUrl($this->getId());
        }
        return null;
    }
}
