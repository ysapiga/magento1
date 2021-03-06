<?php

class Sapiha_Banner_Block_Catalog_List extends Mage_Catalog_Block_Product_List
{
    /**
     * Get array of banners for current page
     *
     * @return array
     */
    protected function getBanners()
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
    protected function isBannerNeedBeShowed(Sapiha_Banner_Block_Catalog_Banner $banner, $iterator)
    {
        $banner->setMode($this->getMode());
        $bannerPosition = $banner->getPosition();
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
    protected function printBanner($banner)
    {
        $banner->setMode($this->getMode());
        return $banner->toHtml();
    }
}
