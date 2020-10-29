<?php
namespace Magepow\OnestepCheckout\Observer;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Event\ObserverInterface;
use Magepow\OnestepCheckout\Helper\Data;

/**
 * Class CheckoutSubmitBefore
 * @package Magepow\OnestepCheckout\Observer
 */
class IsAllowedGuestCheckoutObserver extends \Magento\Downloadable\Observer\IsAllowedGuestCheckoutObserver implements ObserverInterface
{
    /**
     * @var Data
     */
    protected $_helper;

    /**
     * IsAllowedGuestCheckoutObserver constructor.
     * @param ScopeConfigInterface $scopeConfig
     * @param Data $helper
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        Data $helper
    )
    {
        $this->_helper = $helper;

        parent::__construct($scopeConfig);
    }

    /**
     * @inheritdoc
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if ($this->_helper->isEnabled()) {
            return $this;
        }

        return parent::execute($observer);
    }
}
