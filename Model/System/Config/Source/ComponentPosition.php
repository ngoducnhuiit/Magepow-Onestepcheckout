<?php
namespace Magepow\OnestepCheckout\Model\System\Config\Source;

use Magento\Framework\Model\AbstractModel;

/**
 * Class ComponentPosition
 * @package Magepow\OnestepCheckout\Model\System\Config\Source
 */
class ComponentPosition extends AbstractModel
{
    const NOT_SHOW        = 0;
    const SHOW_IN_PAYMENT = 1;
    const SHOW_IN_REVIEW  = 2;

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            self::NOT_SHOW        => __('No'),
            self::SHOW_IN_PAYMENT => __('In Payment Area'),
            self::SHOW_IN_REVIEW  => __('In Review Area')
        ];
    }
}
