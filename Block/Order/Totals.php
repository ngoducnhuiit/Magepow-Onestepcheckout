<?php

namespace Magepow\OnestepCheckout\Block\Order;

use Magento\Framework\DataObject;
use Magento\Framework\View\Element\Template;

/**
 * Class GiftWrap
 * @package Magepow\OnestepCheckout\Block\Totals\Order
 */
class Totals extends Template
{
    /**
     * Init Totals
     */
    public function initTotals()
    {
        $totalsBlock = $this->getParentBlock();
        $source      = $totalsBlock->getSource();
        if ($source && !empty($source->getGiftWrapAmount())) {
            $totalsBlock->addTotal(new DataObject([
                'code'  => 'gift_wrap',
                'field' => 'onestepcheckout_gift_wrap_amount',
                'label' => __('Gift Wrap'),
                'value' => $source->getGiftWrapAmount(),
            ]));
        }
    }
}
