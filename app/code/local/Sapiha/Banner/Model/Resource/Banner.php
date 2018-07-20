<?php

class Sapiha_Banner_Model_Resource_Banner extends Mage_Core_Model_Mysql4_Abstract
{
    /**
     * @inheritdoc
     */
    public function _construct()
    {
        $this->_init('sapiha_banner/table_banner', 'id');
    }

    /**
     * Return banner_id by widget id
     *
     * @param $widgetId
     * @return string
     */
    public function getIdByWidgetId($widgetId)
    {
        $adapter = $this->_getReadAdapter();
        $select = $adapter->select()
            ->from($this->getMainTable(), 'id')
            ->where('banner_id=?', $widgetId);

        return $adapter->fetchOne($select);
    }
}
