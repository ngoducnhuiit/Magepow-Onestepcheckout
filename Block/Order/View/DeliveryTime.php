<?php
namespace Magepow\OnestepCheckout\Block\Order\View;

use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class DeliveryTime extends Template
{
    /**
     * @type Registry|null
     */
    protected $_coreRegistry = null;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        array $data = []
    )
    {
        $this->_coreRegistry = $registry;

        parent::__construct($context, $data);
    }

    /**
     * Get onestepcheckout delivery time
     *
     * @return string
     */
    public function getDeliveryTime()
    {
        if ($order = $this->getOrder()) {
            return $order->getDeliveryTime();
        }

        return '';
    }

    /**
     * Get onestepcheckout house security code
     *
     * @return string
     */
    public function getHouseSecurityCode()
    {
        if ($order = $this->getOrder()) {
            return $order->getOrderHouseSecurityCode();
        }

        return '';
    }

    /**
     * Get current order
     *
     * @return mixed
     */
    public function getOrder()
    {
        return $this->_coreRegistry->registry('current_order');
    }
}
