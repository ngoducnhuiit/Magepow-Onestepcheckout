<?php
namespace Magepow\OnestepCheckout\Model\Plugin\Quote;

use Magento\Quote\Model\Quote as QuoteEntity;

class QuoteManagement
{
    /**
     * @var \Magepow\OnestepCheckout\Model\CheckoutRegister
     */
    protected $checkoutRegister;

    /**
     * QuoteManagement constructor.
     * @param \Magepow\OnestepCheckout\Model\CheckoutRegister $checkoutRegister
     */
    public function __construct(\Magepow\OnestepCheckout\Model\CheckoutRegister $checkoutRegister)
    {
        $this->checkoutRegister = $checkoutRegister;
    }

    /**
     * @param \Magento\Quote\Model\QuoteManagement $subject
     * @param QuoteEntity $quote
     * @param array $orderData
     * @return array
     */
    public function beforeSubmit(\Magento\Quote\Model\QuoteManagement $subject, QuoteEntity $quote, $orderData = [])
    {
        $this->checkoutRegister->checkRegisterNewCustomer();

        return [$quote, $orderData];
    }
}
