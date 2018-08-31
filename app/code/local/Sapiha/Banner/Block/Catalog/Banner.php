<?php

class Sapiha_Banner_Block_Catalog_Banner extends Mage_Core_Block_Template
{
    /**
     * @var string
     */
    protected $image;

    /**
     * @var string
     */
    protected $mode;

    /**
     * @var string
     */
    public $position;

    /**
     * Sapiha_Banner_Block_Catalog_Banner constructor
     */

    public function _construct()
    {
        $this->_template = "sapiha_banner/banner.phtml";
    }

    /**
     * Return banner mode
     *
     * @return string
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * Set banner mode
     *
     * @param $mode
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
             $this->image = $this->getData('imageList');
        } else if($this->getMode() == 'grid') {
            $this->image = $this->getData('image');
        }
        else {
            Mage::throwException('Unsupported product list mode');
        }

        return $this->image;
    }

    /**
     * Get banner position
     *
     * @param string $mode
     * @return string
     * @throws Mage_Core_Exception
     */
    public function getPosition($mode)
    {
        if ($mode == 'list') {
            $this->position = $this->getData('list_position');
        } else if($mode == 'grid') {
            $this->position = $this->getData('grid_position');
        }
        else {
            Mage::throwException('Unsupported product list mode');
        }

        return $this->position;
    }
}
