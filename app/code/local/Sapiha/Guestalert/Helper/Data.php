<?php

class Sapiha_Guestalert_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Validation before save entity
     *
     * @param string $email
     * @param int $productId
     * @param string $type
     * @return bool
     */
    public function checkCandidate($email, $productId, $type) {
        $permission = true;
        $collection =  Mage::getModel("sapiha_guestalert/$type")->getCollection();

        foreach ($collection as $item) {
            if ($email == $item->getGuestEmail() && $productId == $item->getProductId()) {
                $permission = false;
            }
        }

        return $permission;
    }
}
