<?php


namespace Magepow\OnestepCheckout\Model\System\Config\Source;

/**
 * Class Checkbox Style
 * @package Magepow\OnestepCheckout\Model\System\Config\Source
 */
class CheckboxStyle
{
    const STYLE_DEFAULT = 'default';
    const FILLED_IN     = 'filled_in';

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
                'label' => __('Filled In'),
                'value' => self::FILLED_IN
            ]
        ];

        return $options;
    }
}
