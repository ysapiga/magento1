<?php

class Sapiha_Banner_Block_Catalog_Banner extends Mage_Core_Block_Template
{
    /**
     * Sapiha_Banner_Block_Catalog_Banner constructor
     */
    public function _construct()
    {
        $this->_template = "sapiha_banner/banner.phtml";
    }

    /**
     * Set appropriate banner image
     *
     * @param array $bannerInfo
     * @param string $type
     * @return array
     * @throws Mage_Core_Exception
     */
    public function convertImage($bannerInfo, $type)
    {
        if ($type == 'list') {
            $bannerInfo['image'] = $bannerInfo['imageList'];
        } elseif ($type!= 'list' && $type != 'grid') {
            Mage::throwException('Unsupported product list mode');
        }

        return $bannerInfo;
    }

    /**
     * @param array $bannerInfo
     * @param string $type
     * @return void
     * @throws Mage_Core_Exception
     */
    public function printBanner($bannerInfo, $type)
    {
        return $this->setData( $this->convertImage($bannerInfo, $type))->toHtml();
    }
}
