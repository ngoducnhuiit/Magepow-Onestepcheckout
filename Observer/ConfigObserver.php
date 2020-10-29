<?php
namespace Magepow\OnestepCheckout\Observer;

use Magento\Config\Model\ResourceModel\Config as ModelConfig;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Message\ManagerInterface as MessageManager;
use Magento\GiftMessage\Helper\Message;
use Magepow\OnestepCheckout\Helper\Data;

/**
 * Class ConfigObserver
 * @package Magepow\OnestepCheckout\Observer
 */
class ConfigObserver implements ObserverInterface
{
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var ModelConfig
     */
    protected $_modelConfig;

    /**
     * @var MessageManager
     */
    protected $_messageManager;

    /**
     * @var Data
     */
    protected $dataHelper;

    /**
     * ConfigObserver constructor.
     * @param ModelConfig $modelConfig
     * @param MessageManager $messageManager
     * @param Data $dataHelper
     */
    public function __construct(
        ModelConfig $modelConfig,
        MessageManager $messageManager,
        Data $dataHelper
    )
    {
        $this->_modelConfig    = $modelConfig;
        $this->_messageManager = $messageManager;
        $this->dataHelper      = $dataHelper;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(Observer $observer)
    {
        $scopeId            = 0;
        $isGiftMessage      = !$this->dataHelper->isDisabledGiftMessage();
        $isGiftMessageItems = $this->dataHelper->isEnableGiftMessageItems();
        $isEnableTOC        = ($this->dataHelper->disabledPaymentTOC() || $this->dataHelper->disabledReviewTOC());
        $this->_modelConfig
            ->saveConfig(
                Message::XPATH_CONFIG_GIFT_MESSAGE_ALLOW_ORDER,
                $isGiftMessage,
                ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
                $scopeId
            )
            ->saveConfig(
                Message::XPATH_CONFIG_GIFT_MESSAGE_ALLOW_ITEMS,
                $isGiftMessageItems,
                ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
                $scopeId
            )
            ->saveConfig(
                'checkout/options/enable_agreements',
                $isEnableTOC,
                ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
                $scopeId
            );

        $isEnableGeoIP = $this->dataHelper->isEnableGeoIP();
        if ($isEnableGeoIP && !$this->dataHelper->getAddressHelper()->checkHasLibrary()) {
            $this->_modelConfig->saveConfig(
                Data::GEO_IP_IS_ENABLED,
                false,
                ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
                $scopeId
            );
            $this->_messageManager->addNoticeMessage(__("Notice: Please download GeoIp library before enable."));
        }
    }
}
