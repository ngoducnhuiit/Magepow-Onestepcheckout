<?php
namespace Magepow\OnestepCheckout\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magepow\OnestepCheckout\Model\CheckoutRegister;

/**
 * Class PaypalExpressPlaceOrder
 * @package Magepow\OnestepCheckout\Observer
 */
class PaypalExpressPlaceOrder implements ObserverInterface
{
    /**
     * @var \Magepow\OnestepCheckout\Model\CheckoutRegister
     */
    protected $checkoutRegister;

    /**
     * PaypalExpressPlaceOrder constructor.
     * @param \Magepow\OnestepCheckout\Model\CheckoutRegister $checkoutRegister
     */
    public function __construct(CheckoutRegister $checkoutRegister)
    {
        $this->checkoutRegister = $checkoutRegister;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function execute(Observer $observer)
    {
        $this->checkoutRegister->checkRegisterNewCustomer();
    }
}
