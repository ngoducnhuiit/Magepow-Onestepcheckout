<?php
namespace Magepow\OnestepCheckout\Model\System\Config\Source;

use Magento\Framework\Model\AbstractModel;


class StaticBlockPosition extends AbstractModel
{
    const NOT_SHOW                     = 0;
    const SHOW_IN_SUCCESS_PAGE         = 1;
    const SHOW_AT_TOP_CHECKOUT_PAGE    = 2;
    const SHOW_AT_BOTTOM_CHECKOUT_PAGE = 3;

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            self::NOT_SHOW                     => __('None'),
            self::SHOW_IN_SUCCESS_PAGE         => __('In Success Page'),
            self::SHOW_AT_TOP_CHECKOUT_PAGE    => __('At Top of Checkout Page'),
            self::SHOW_AT_BOTTOM_CHECKOUT_PAGE => __('At Bottom of Checkout Page')
        ];
    }
}
