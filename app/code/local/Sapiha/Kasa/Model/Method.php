<?php

class Sapiha_Kasa_Model_Method extends Mage_Payment_Model_Method_Abstract
{
    /**
     * @var string
     */
    protected $_code = 'sapiha_kasa';

    /**
     * @var string
     */
    const CODE = 'sapiha_kasa';

    /**
     * @var bool
     */
    protected $_canUseForMultishipping  = false;
}
