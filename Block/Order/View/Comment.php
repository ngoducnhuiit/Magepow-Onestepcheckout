<?php

namespace Magepow\OnestepCheckout\Block\Order\View;

use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

/**
 * Class Comment
 * @package Magepow\OnestepCheckout\Block\Order\View
 */
class Comment extends Template
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
     * Get onestepcheckout order comment
     *
     * @return string
     */
    public function getOrderComment()
    {
        if ($order = $this->getOrder()) {
            return $order->getOrderComment();
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
