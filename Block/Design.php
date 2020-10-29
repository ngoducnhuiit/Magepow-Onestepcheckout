<?php

namespace Magepow\OnestepCheckout\Block;

use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Framework\View\Design\Theme\ThemeProviderInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magepow\OnestepCheckout\Helper\Data;

class Design extends Template
{
    /**
     * @var Data
     */
    protected $dataHelper;

    /**
     * @var ThemeProviderInterface
     */
    protected $_themeProviderInterface;

    /**
     * @type \Magento\Checkout\Model\Session
     */
    private $checkoutSession;

    /**
     * Design constructor.
     * @param Context $context
     * @param Data $dataHelper
     * @param ThemeProviderInterface $themeProviderInterface
     * @param CheckoutSession $checkoutSession
     * @param array $data
     */
    public function __construct(
        Context $context,
        Data $dataHelper,
        ThemeProviderInterface $themeProviderInterface,
        CheckoutSession $checkoutSession,
        array $data = []
    )
    {
        parent::__construct($context, $data);

        $this->dataHelper              = $dataHelper;
        $this->_themeProviderInterface = $themeProviderInterface;
        $this->checkoutSession         = $checkoutSession;
    }
    public function getHelperConfig()
    {
        return $this->dataHelper;
    }

    /**
     * @return bool
     */
    public function isEnableGoogleApi()
    {
        return $this->getHelperConfig()->getAutoDetectedAddress() == 'google';
    }
    /**
     * @return mixed
     */
    public function getGoogleApiKey()
    {
        return $this->getHelperConfig()->getGoogleApiKey();
    }

    /**
     * @return bool
     */
    public function isEnableExperian()
    {
        return $this->getHelperConfig()->getAutoDetectedAddress() == 'eav';
    }

    /**
     * @return mixed
     */

    public function getExperianApiKey()
    {
        return $this->getHelperConfig()->getExperianKey();
    }

    /**
     * @return array
     */
    public function getDesignConfiguration()
    {
        return $this->getHelperConfig()->getDesignConfig();
    }

    /**
     * @return string
     */
    public function getCurrentTheme()
    {
        return $this->_themeProviderInterface->getThemeById($this->getHelperConfig()->getCurrentThemeId())->getCode();
    }

    /**
     * @return bool
     */
    public function isVirtual()
    {
        return $this->checkoutSession->getQuote()->isVirtual();
    }
}
