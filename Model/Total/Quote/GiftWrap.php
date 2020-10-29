<?php
namespace Magepow\OnestepCheckout\Model\Total\Quote;

use Magento\Checkout\Model\Session;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Quote\Api\Data\ShippingAssignmentInterface;
use Magento\Quote\Model\Quote;
use Magento\Quote\Model\Quote\Address;
use Magento\Quote\Model\Quote\Address\Total;
use Magento\Quote\Model\Quote\Address\Total\AbstractTotal;
use Magepow\OnestepCheckout\Helper\Data;
use Magepow\OnestepCheckout\Model\System\Config\Source\Giftwrap as SourceGiftwrap;

/**
 * Class GiftWrap
 * @package Magepow\OnestepCheckout\Model\Total\Quote
 */
class GiftWrap extends AbstractTotal
{
    /**
     * @var Data
     */
    protected $dataHelper;

    /**
     * @type \Magento\Checkout\Model\Session
     */
    protected $_checkoutSession;

    /**
     * @type \Magento\Framework\Pricing\PriceCurrencyInterface
     */
    protected $priceCurrency;

    /**
     * @type
     */
    protected $_baseGiftWrapAmount;

    /**
     * GiftWrap constructor.
     * @param Session $checkoutSession
     * @param Data $dataHelper
     * @param PriceCurrencyInterface $priceCurrency
     */
    public function __construct(
        Session $checkoutSession,
        Data $dataHelper,
        PriceCurrencyInterface $priceCurrency
    )
    {
        $this->_checkoutSession = $checkoutSession;
        $this->dataHelper       = $dataHelper;
        $this->priceCurrency    = $priceCurrency;

        $this->setCode('onestepcheckout_gift_wrap');
    }

    /**
     * Collect gift wrap totals
     *
     * @param Quote $quote
     * @param ShippingAssignmentInterface $shippingAssignment
     * @param Total $total
     * @return $this
     */
    public function collect(
        Quote $quote,
        ShippingAssignmentInterface $shippingAssignment,
        Total $total
    )
    {
        parent::collect($quote, $shippingAssignment, $total);

        if ($this->dataHelper->isDisabledGiftWrap() ||
            ($shippingAssignment->getShipping()->getAddress()->getAddressType() !== Address::TYPE_SHIPPING) ||
            !$quote->getShippingAddress()->getUsedGiftWrap()
        ) {
            return $this;
        }

        $baseGiftWrapAmount = $this->calculateGiftWrapAmount($quote);
        $GiftWrapAmount     = $this->priceCurrency->convert($baseGiftWrapAmount, $quote->getStore());

        $this->_addAmount($GiftWrapAmount);
        $this->_addBaseAmount($baseGiftWrapAmount);

        return $this;
    }

    /**
     * Assign gift wrap amount and label to address object
     *
     * @param \Magento\Quote\Model\Quote $quote
     * @param Address\Total $total
     * @return array
     */
    public function fetch(Quote $quote, Total $total)
    {
        $amount = $total->getGiftWrapAmount();

        $baseInitAmount = $this->calculateGiftWrapAmount($quote);
        $initAmount     = $this->priceCurrency->convert($baseInitAmount, $quote->getStore());

        return [
            'code'             => $this->getCode(),
            'title'            => __('Gift Wrap'),
            'value'            => $amount,
            'gift_wrap_amount' => $initAmount
        ];
    }

    /**
     * @param $quote
     * @return int|mixed
     */
    public function calculateGiftWrapAmount($quote)
    {
        if ($this->_baseGiftWrapAmount == null) {
            $baseGiftWrapAmount = $this->dataHelper->getOrderGiftwrapAmount();
            if ($baseGiftWrapAmount == 0) {
                return 0;
            }

            $giftWrapType = $this->dataHelper->getGiftWrapType();
            if ($giftWrapType == SourceGiftwrap::PER_ITEM) {
                $giftWrapBaseAmount    = $baseGiftWrapAmount;
                $baseGiftWrapAmount = 0;
                foreach ($quote->getAllVisibleItems() as $item) {
                    if ($item->getProduct()->isVirtual() || $item->getParentItem()) {
                        continue;
                    }
                    $baseItemGiftWrapAmount = $giftWrapBaseAmount * $item->getQty();
                    $item->setBaseGiftWrapAmount($baseItemGiftWrapAmount);
                    $item->setGiftWrapAmount($this->priceCurrency->convert($baseItemGiftWrapAmount, $quote->getStore()));

                    $baseGiftWrapAmount += $baseItemGiftWrapAmount;
                }
            }
            $quote->getShippingAddress()->setGiftWrapType($giftWrapType);

            $this->_baseGiftWrapAmount = $baseGiftWrapAmount;
        }

        return $this->_baseGiftWrapAmount;
    }
}
