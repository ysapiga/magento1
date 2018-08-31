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
     * @param Sapiha_Banner_Block_Catalog_Banner $banner
     * @param int $iterator
     * @return bool
     */
    public function isBannerNeedBeShowed(Sapiha_Banner_Block_Catalog_Banner $banner, $iterator)
    {
        $bannerPosition = $banner->getPosition($this->getMode());
        $currentPage = $this->_productCollection->getCurPage();
        $startPossition = ($currentPage > 1) ? 12 * ($currentPage - 1) : 0 ;
        $currentIteration = $startPossition + $iterator;
        $isBannerActive = (bool) $banner->getData('is_active');

        return $currentPage <= 3 && $bannerPosition == $currentIteration && $isBannerActive;
    }

    /**
     * Print banner
     *
     * @param Sapiha_Banner_Block_Catalog_Banner $banner
     * @return string
     */
    public function printBanner($banner)
    {
        return $banner->toHtml();
    }
}
