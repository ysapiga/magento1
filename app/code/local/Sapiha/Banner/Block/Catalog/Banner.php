<?php

class Sapiha_Banner_Block_Catalog_Banner extends Mage_Core_Block_Template
{
    /**
     * @var string
     */
    protected $mode;

    public function _construct()
    {
        $this->_template = "sapiha_banner/banner.phtml";
    }

    /**
     * Set banner mode
     *
     * @param string $mode
     * @return $this
     */
    public function setMode($mode)
    {
        $this->mode = $mode;

        return $this;
    }

    /**
     * Get appropriate banner image
     *
     * @return Sapiha_Banner_Block_Catalog_Banner
     * @throws Mage_Core_Exception
     */
    public function getImage()
    {
        if ($this->getMode() == 'list') {
             $image = Mage::getBaseUrl('media') . $this->getData('imageList');
        } else if($this->getMode() == 'grid') {
            $image = Mage::getBaseUrl('media') . $this->getData('image');
        } else {
            Mage::throwException('Unsupported product list mode');
        }

        return $image;
    }

    /**
     * Get banner position
     *
     * @param string $mode
     * @return string
     * @throws Mage_Core_Exception
     */
    public function getPosition()
    {
        if ($this->getMode() == 'list') {
            $position = $this->getData('list_position');
        } else if($this->getMode() == 'grid') {
            $position = $this->getData('grid_position');
        } else {
            Mage::throwException('Unsupported product list mode');
        }

        return $position;
    }

    /**
     * Returns banner mode
     *
     * @return string
     */
    private function getMode()
    {
        return $this->mode;
    }
}
