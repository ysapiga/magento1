<?php

class Sapiha_Banner_Block_Catalog_Banner extends Mage_Catalog_Block_Product_List
{

    /**
     * Sapiha_Banner_Block_Catalog_Banner constructor
     */
    public function _construct()
    {
        $this->_template = "sapiha_banner/banner.phtml";
    }

    /**
     * Get array of banners for current page
     *
     * @return array
     */
    public function getBanners()
    {
        $banners = [];

        foreach ($this->getSortedChildren() as $banner) {
            if (strpos($banner, 'sapiha_banner') !== false){
                $banners [] = $banner;
            }
        }

        return $banners;
    }

    /**
     * Get banner grid position param
     *
     * @param $banner
     * @return mixed
     */
    public function getBannerGridPosition($banner)
    {
        return $this->getChild($banner)->getData('grid_position');
    }

    /**
     * Get banner list position param
     *
     * @param $banner
     * @return mixed
     */
    public function getBannerListPosition($banner)
    {
        return $this->getChild($banner)->getData('list_position');
    }

    /**
     * @param string $name
     * @param string $type
     * @return mixed
     */
    public function getChild($name = '', $type = '')
    {
        if ($type == 'list') {
            $data = str_replace('grid', 'list', parent::getChild($name)->getData('image'));
            return parent::getChild($name)->setData('image', $data);
        }

        return parent::getChild($name);
    }

    /**
     * Check permission to show banner
     *
     * @param int $iterator
     * @param string $bannerPosition
     * @return bool
     */
    public function isBannerNeedBeShowed($iterator, $bannerPosition)
    {
        $currentPage = $this->_productCollection->getCurPage();
        $startPossition = ($currentPage > 1) ? 12 * ($currentPage - 1) : 0 ;
        $currentIteration = $startPossition + $iterator;

        return $currentPage <= 3 && $bannerPosition == $currentIteration;
    }
}
