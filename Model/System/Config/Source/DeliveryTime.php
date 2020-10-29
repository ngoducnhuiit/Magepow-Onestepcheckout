<?php
namespace Magepow\OnestepCheckout\Model\System\Config\Source;

use Magento\Framework\Model\AbstractModel;

/**
 * Class DeliveryTime
 * @package Magepow\OnestepCheckout\Model\System\Config\Source
 */
class DeliveryTime extends AbstractModel
{
    const DAY_MONTH_YEAR = 'dd/mm/yy';
    const MONTH_DAY_YEAR = 'mm/dd/yy';
    const YEAR_MONTH_DAY = 'yy/mm/dd';

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $options = [
            [
                'label' => __('Day/Month/Year'),
                'value' => self::DAY_MONTH_YEAR
            ],
            [
                'label' => __('Month/Day/Year'),
                'value' => self::MONTH_DAY_YEAR
            ],
            [
                'label' => __('Year/Month/Day'),
                'value' => self::YEAR_MONTH_DAY
            ]
        ];

        return $options;
    }
}
