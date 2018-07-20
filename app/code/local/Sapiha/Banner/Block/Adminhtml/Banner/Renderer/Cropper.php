<?php

class Sapiha_Banner_Block_Adminhtml_Banner_Renderer_Cropper extends  Varien_Data_Form_Element_Abstract
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $ratio;

    /**
     * Sapiha_Banner_Block_Adminhtml_Banner_Renderer_Cropper constructor.
     * @param array $attributes
     */
    public function __construct($attributes=array())
    {
        parent::__construct($attributes);
        $this->type = $attributes['view_type'];
        $this->ratio = $attributes['ratio'];
    }

    /**
     * Generate html for crooper element
     *
     * @return string
     */
    public function getElementHtml()
    {
        $html =
            '<img src="" id="'. $this->type .'croopedImage" name = "'. $this->type .'croopedImage"/>'
            .'<input type = "hidden" id="'. $this->type .'x" name = "'. $this->type .'x"/>'
            .'<input type = "hidden" id="'. $this->type .'y" name = "'. $this->type .'y"/>'
            .'<input type = "hidden" id="'. $this->type .'width" name = "'. $this->type .'width"/>'
            .'<input type = "hidden" id="'. $this->type .'height" name = "'. $this->type .'height"/>'
            .'<input type = "hidden" id="'. $this->type .'ratio" value = "'. $this->ratio     .'" name = "'. $this->type .'ratio"/>'
        ;

        return $html;
    }
}
