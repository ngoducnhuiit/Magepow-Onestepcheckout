<?php


namespace Magepow\OnestepCheckout\Model\System\Config\Source;

use Magento\Framework\Model\AbstractModel;

/**
 * Class Giftwrap
 * @package Magepow\OnestepCheckout\Model\System\Config\Source
 */
class Giftwrap extends AbstractModel
{
    const PER_ORDER = 0;
    const PER_ITEM  = 1;

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            self::PER_ORDER => __('Per Order'),
            self::PER_ITEM  => __('Per Item')
        ];
    }
}
