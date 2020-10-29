<?php
namespace Magepow\OnestepCheckout\Model\Plugin\Customer;

use Magento\Checkout\Model\Session;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Model\AccountManagement as AM;

/**
 * Class Address
 * @package Magepow\OnestepCheckout\Model\Plugin\Customer
 */
class AccountManagement
{
    /**
     * @var Session
     */
    protected $checkoutSession;

    /**
     * AccountManagement constructor.
     * @param Session $checkoutSession
     */
    public function __construct(Session $checkoutSession)
    {
        $this->checkoutSession = $checkoutSession;
    }

    /**
     * @param AM $subject
     * @param mixed $password
     * @param mixed $redirectUrl
     * @return mixed
     */
    public function beforeCreateAccount(AM $subject, CustomerInterface $customer, $password = null, $redirectUrl = '')
    {
        $data = $this->checkoutSession->getData();
        if (isset($data['register']) && $data['register'] && isset($data['password']) && $data['password']) {
            $password = $data['password'];

            return [$customer, $password, $redirectUrl];
        }
    }
}
