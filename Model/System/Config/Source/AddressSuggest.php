<?php

namespace Magepow\OnestepCheckout\Model\System\Config\Source;

/**
 * Class Suggest
 * @package Magepow\OnestepCheckout\Model\System\Config\Source\Address
 */
class AddressSuggest
{
    /**
     * @return array
     */
    public function getTriggerOption()
    {
        return [
            ''       => __('No'),
            'google' => __('Google'),
            'eav'    => __('Experian'),
        ];
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $options = [];
        foreach ($this->getTriggerOption() as $code => $label) {
            $options[] = [
                'value' => $code,
                'label' => $label
            ];
        }

        return $options;
    }
}
