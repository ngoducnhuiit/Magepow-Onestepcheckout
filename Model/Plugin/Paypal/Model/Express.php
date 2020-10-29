<?php
namespace Magepow\OnestepCheckout\Model\Plugin\Paypal\Model;

use Magento\Quote\Api\Data\PaymentInterface;

/**
 * Class Express
 * @package Magepow\OnestepCheckout\Model\Plugin\Paypal\Model
 */
class Express
{
    /**
     * @param \Magento\Paypal\Model\Express $express
     * @param \Magento\Framework\DataObject $data
     * @return array
     */
    public function beforeAssignData(\Magento\Paypal\Model\Express $express, \Magento\Framework\DataObject $data)
    {
        $additionalData = $data->getData(PaymentInterface::KEY_ADDITIONAL_DATA);
        if (is_array($additionalData) && isset($additionalData['extension_attributes'])) {
            unset($additionalData['extension_attributes']);
            $data->setData(PaymentInterface::KEY_ADDITIONAL_DATA, $additionalData);
        }

        return [$data];
    }
}
