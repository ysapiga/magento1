<?php

class Sapiha_Banner_Block_Catalog_List extends Mage_Catalog_Block_Product_List
{
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