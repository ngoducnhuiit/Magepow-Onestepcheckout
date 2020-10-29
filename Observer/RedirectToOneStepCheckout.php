<?php
namespace Magepow\OnestepCheckout\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\UrlInterface;
use Magepow\OnestepCheckout\Helper\Data;

class RedirectToOneStepCheckout implements ObserverInterface
{
    /**
     * @var UrlInterface
     */
    protected $_url;

    /**
     * @var Data
     */
    protected $dataHelper;

    /**
     * RedirectToOneStepCheckout constructor.
     * @param UrlInterface $url
     * @param Data $dataHelper
     */
    public function __construct(
        UrlInterface $url,
        Data $dataHelper
    )
    {
        $this->_url       = $url;
        $this->dataHelper = $dataHelper;
    }

    /**
     * @param Observer $observer
     * @return void
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function execute(Observer $observer)
    {
        if ($this->dataHelper->isEnabled() && $this->dataHelper->isRedirectToOneStepCheckout()) {
            $observer->getRequest()->setParam('return_url', $this->_url->getUrl('onestepcheckout'));
        }
    }
}
