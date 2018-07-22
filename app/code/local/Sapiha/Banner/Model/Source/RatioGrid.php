<?php

class Sapiha_Banner_Model_Source_RatioGrid
{
    /**
     * @var array
     */
    private $options;

    /**
     * Return options as array
     *
     * @return array
     */
    public function toOptionArray()
    {
        $this->options = [
            ['value'=>'1/2.25', 'label'=>'1/2.25' ],
            ['value'=>'1/3', 'label'=>'1/3' ],
        ];

        return $this->options;
    }
}
