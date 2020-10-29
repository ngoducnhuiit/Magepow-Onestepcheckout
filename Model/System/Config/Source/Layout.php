<?php
namespace Magepow\OnestepCheckout\Model\System\Config\Source;

/**
 * Class Layout
 * @package Magepow\OnestepCheckout\Model\System\Config\Source
 */
class Layout
{
    const ONE_COLUMN                 = '1column';
    const TWO_COLUMNS                = '2columns';
    const TWO_COLUMNS_FLOATING       = '2columns-floating';
    const THREE_COLUMNS              = '3columns';
    const THREE_COLUMNS_WITH_COLSPAN = '3columns-colspan';

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $options = [
            [
                'label' => __('1 Column'),
                'value' => self::ONE_COLUMN
            ],
            [
                'label' => __('2 Columns'),
                'value' => self::TWO_COLUMNS
            ],
            [
                'label' => __('2 With Floating '),
                'value' => self::TWO_COLUMNS_FLOATING
            ],
            [
                'label' => __('3 Columns'),
                'value' => self::THREE_COLUMNS
            ],
            [
                'label' => __('3 Columns With Colspan'),
                'value' => self::THREE_COLUMNS_WITH_COLSPAN
            ]
        ];

        return $options;
    }
}
