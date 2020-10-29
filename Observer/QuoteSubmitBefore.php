<?php


namespace Magepow\OnestepCheckout\Observer;

use Magento\Checkout\Model\Session;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class QuoteSubmitBefore implements ObserverInterface
{
    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $checkoutSession;

    /**
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @codeCoverageIgnore
     */
    public function __construct(Session $checkoutSession)
    {
        $this->checkoutSession = $checkoutSession;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function execute(Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        $quote = $observer->getEvent()->getQuote();

        $data = $this->checkoutSession->getData();
        if (isset($data['comment'])) {
            $order->setData('onestepcheckout_order_comment', $data['comment']);
        }

        if (isset($data['deliveryTime'])) {
            $order->setData('onestepcheckout_delivery_time', $data['deliveryTime']);
        }

        if (isset($data['houseSecurityCode'])) {
            $order->setData('onestepcheckout_order_house_security_code', $data['houseSecurityCode']);
        }

        $address = $quote->getShippingAddress();
        if ($address->getUsedGiftWrap() && $address->hasData('onestepcheckout_gift_wrap_amount') && $address->getUsedGiftWrap()) {
            $order->setData('gift_wrap_type', $address->getGiftWrapType())
                ->setData('onestepcheckout_gift_wrap_amount', $address->getGiftWrapAmount())
                ->setData('base_onestepcheckout_gift_wrap_amount', $address->getBaseGiftWrapAmount());

            foreach ($order->getItems() as $item) {
                $quoteItem = $quote->getItemById($item->getQuoteItemId());
                if ($quoteItem && $quoteItem->hasData('onestepcheckout_gift_wrap_amount')) {
                    $item->setData('onestepcheckout_gift_wrap_amount', $quoteItem->getGiftWrapAmount())
                        ->setData('base_onestepcheckout_gift_wrap_amount', $quoteItem->getBaseGiftWrapAmount());
                }
            }
        }
    }
}
