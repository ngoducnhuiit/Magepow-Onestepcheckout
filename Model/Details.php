<?php
namespace Magepow\OnestepCheckout\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use Magepow\OnestepCheckout\Api\Data\DetailsInterface;

/**
 * @codeCoverageIgnoreStart
 */
class Details extends AbstractExtensibleModel implements DetailsInterface
{
    /**
     * @{inheritdoc}
     */
    public function getShippingMethods()
    {
        return $this->getData(self::SHIPPING_METHODS);
    }

    /**
     * @{inheritdoc}
     */
    public function setShippingMethods($shippingMethods)
    {
        return $this->setData(self::SHIPPING_METHODS, $shippingMethods);
    }

    /**
     * @{inheritdoc}
     */
    public function getPaymentMethods()
    {
        return $this->getData(self::PAYMENT_METHODS);
    }

    /**
     * @{inheritdoc}
     */
    public function setPaymentMethods($paymentMethods)
    {
        return $this->setData(self::PAYMENT_METHODS, $paymentMethods);
    }

    /**
     * @{inheritdoc}
     */
    public function getTotals()
    {
        return $this->getData(self::TOTALS);
    }

    /**
     * @{inheritdoc}
     */
    public function setTotals($totals)
    {
        return $this->setData(self::TOTALS, $totals);
    }

    /**
     * @return string
     */
    public function getRedirectUrl()
    {
        return $this->getData(self::REDIRECT_URL);
    }

    /**
     * @param $url
     * @return $this
     */
    public function setRedirectUrl($url)
    {
        return $this->setData(self::REDIRECT_URL, $url);
    }
}
