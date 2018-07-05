<?php

class Sapiha_News_Model_Resource_News extends Mage_Core_Model_Mysql4_Abstract
{
    /**
     * @inheritdoc
     */
    public function _construct()
    {
        $this->_init('sapiha_news/table_news', 'id');
    }
}
