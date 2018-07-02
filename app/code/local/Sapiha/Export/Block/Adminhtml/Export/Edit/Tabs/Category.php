<?php

class Sapiha_Export_Block_Adminhtml_Export_Edit_Tabs_Category extends Mage_Adminhtml_Block_Catalog_Product_Edit_Tab_Categories
{

    protected $_categoryIds;
    protected $_selectedNodes = null;

    /**
     * Specify template to use
     */
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('sapiha_export/edit/category.phtml');
    }

    /**
     * Retrieve currently edited product
     *
     * @return Mage_Catalog_Model_Product
     */
    public function getProduct()
    {
        return Mage::registry('current_export');
    }

    /**
     * Checks when this block is readonly
     *
     * @return boolean
     */
    public function isReadonly()
    {
        return $this->getProduct()->getCategoriesReadonly();
    }

    /**
     * Return array with category IDs which the product is assigned to
     *
     * @return array
     */
    protected function getCategoryIds()
    {
        return explode(',',$this->getProduct()->getCategoryIds());
    }

    /**
     * Forms string out of getCategoryIds()
     *
     * @return string
     */
    public function getIdsString()
    {
        return implode(',',$this->getCategoryIds());
    }
}
