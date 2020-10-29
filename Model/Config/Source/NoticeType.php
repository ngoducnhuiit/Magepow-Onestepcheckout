<?php
namespace Magepow\OnestepCheckout\Model\Config\Source;

/**
 * Class NoticeType
 * @package Magepow\OnestepCheckout\Model\Config\Source
 */
class NoticeType extends AbstractSource
{
    const TYPE_ANNOUNCEMENT = 'announcement';
    const TYPE_NEWUPDATE    = 'new_update';
    const TYPE_MARKETING    = 'marketing';

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return [
            self::TYPE_ANNOUNCEMENT => __('Announcement'),
            self::TYPE_NEWUPDATE    => __('New & Update extensions'),
            self::TYPE_MARKETING    => __('Promotions ')
        ];
    }
}
