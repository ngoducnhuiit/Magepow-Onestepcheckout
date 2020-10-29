<?php
namespace Magepow\OnestepCheckout\Model\Plugin\Customer;

use Magento\Customer\Api\Data\AddressInterface;

/**
 * Class Address
 * @package Magepow\OnestepCheckout\Model\Plugin\Customer
 */
class Address
{
    /**
     * @param \Magento\Customer\Model\Address $subject
     * @param \Closure $proceed
     * @param \Magento\Customer\Api\Data\AddressInterface $address
     * @return mixed
     */
    public function aroundUpdateData(\Magento\Customer\Model\Address $subject, \Closure $proceed, AddressInterface $address)
    {
        $object = $proceed($address);

        $addressData = $address->__toArray();
        if (isset($addressData['should_ignore_validation'])) {
            $object->setShouldIgnoreValidation($addressData['should_ignore_validation']);
        }

        return $object;
    }
}
