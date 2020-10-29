<?php

namespace Magepow\OnestepCheckout\Model\System\Config\Source;

/**
 * Class Radio Style
 * @package Magepow\OnestepCheckout\Model\System\Config\Source
 */
class RadioStyle
{
    const STYLE_DEFAULT = 'default';
    const WITH_GAP      = 'with_gap';

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $options = [
            [
                'label' => __('Default'),
                'value' => self::STYLE_DEFAULT
            ],
            [
                'label' => __('With Gap'),
                'value' => self::WITH_GAP
            ]
        ];

        return $options;
    }
}
