<?php
namespace Magepow\OnestepCheckout\Model\System\Config\Source;

class Design
{
    const DESIGN_DEFAULT  = 'default';
    const DESIGN_FLAT     = 'flat';
    const DESIGN_MATERIAL = 'material';

    public function toOptionArray()
    {
        $options = [
            [
                'label' => __('Default'),
                'value' => self::DESIGN_DEFAULT
            ],
            [
                'label' => __('Flat'),
                'value' => self::DESIGN_FLAT
            ],
            [
                'label' => __('Material'),
                'value' => self::DESIGN_MATERIAL
            ]
        ];

        return $options;
    }
}
