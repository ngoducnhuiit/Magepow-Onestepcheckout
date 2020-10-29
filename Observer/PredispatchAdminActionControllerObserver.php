<?php
namespace Magepow\OnestepCheckout\Observer;

use Magento\Backend\Model\Auth\Session;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magepow\OnestepCheckout\Helper\Data;
use Magepow\OnestepCheckout\Model\Feed;

class PredispatchAdminActionControllerObserver implements ObserverInterface
{
    /**
     * @type Session
     */
    protected $_backendAuthSession;

    /**
     * @var Data
     */
    protected $helper;

    /**
     * PredispatchAdminActionControllerObserver constructor.
     *
     * @param Session $backendAuthSession
     * @param Data $helper
     */
    public function __construct(
        Session $backendAuthSession,
        Data $helper
    ) {
        $this->_backendAuthSession = $backendAuthSession;
        $this->helper = $helper;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        if ($this->_backendAuthSession->isLoggedIn()
            && $this->helper->isModuleOutputEnabled('Magento_AdminNotification')) {
            /* @var $feedModel Feed */
            $feedModel = $this->helper->createObject(Feed::class);
            $feedModel->checkUpdate();
        }
    }
}
