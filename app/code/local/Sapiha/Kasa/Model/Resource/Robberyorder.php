<?php

class Sapiha_Kasa_Model_Resource_Robberyorder extends Mage_Core_Model_Mysql4_Abstract
{
    /**
     * @inheritdoc
     */
    public function _construct()
    {
        $this->_init('sapiha_kasa/table_kasa_order', 'robbery_id');
    }

    /**
     * Load robberyorder model by order_id
     *
     * @param string $orderId
     * @return string
     */
    public function loadByOrderId($orderId)
    {
        $adapter = $this->_getReadAdapter();
        $select = $adapter->select()
            ->from($this->getMainTable(), 'robbery_id')
            ->where('order_id=?', $orderId);

        return $adapter->fetchOne($select);
    }
}
