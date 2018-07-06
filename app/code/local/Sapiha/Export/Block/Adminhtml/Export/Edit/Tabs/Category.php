<?php

class Sapiha_Export_Block_Adminhtml_Export_Edit_Tabs_Category extends Mage_Adminhtml_Block_Catalog_Product_Edit_Tab_Categories
{
    /**
     * @var array
     */
    protected $_categoryIds;

    /**
     * @var array
     */
    protected $_selectedNodes = null;

    /**
     * @inheritdoc
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
     * Returns category ids as string
     *
     * @return array
     */
    protected function getCategoryIds()
    {
        return explode(',', $this->getProduct()->getCategoryIds());
    }

    /**
     * Forms string out of getCategoryIds()
     *
     * @return string
     */
    public function getIdsString()
    {
        return implode(',', $this->getCategoryIds());
    }
}
