<?php

class Sapiha_Banner_Model_Source_RatioList
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
            ['value'=>'1/0.42', 'label'=>'1/0.42',],
            ['value'=>'1/0.8', 'label'=>'1/0.8',],
        ];

        return $this->options;
    }
}
