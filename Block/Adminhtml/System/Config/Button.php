<?php
/**
 * Button
 *
 * @copyright Copyright © 2020 Magepow. All rights reserved.
 * @author    @copyright Copyright (c) 2014 Magepow (<https://www.magepow.com>)
 * @license <https://www.magepow.com/license-agreement.html>
 * @Author: magepow<support@magepow.com>
 * @github: <https://github.com/magepow>
 */

namespace Magepow\OnestepCheckout\Block\Adminhtml\System\Config;
use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Exception\LocalizedException;
use Magepow\OnestepCheckout\Helper\Data;
use Magepow\OnestepCheckout\Helper\Validate;

class Button  extends Field
{
    protected $_template = 'button.phtml';

    protected $_helper;

    /**
     * Button constructor.
     *
     * @param Context $context
     * @param Validate $helper
     * @param array $data
     */
    public function __construct(
        Context $context,
        Validate $helper,
        array $data = []
    ) {
        $this->_helper = $helper;

        parent::__construct($context, $data);
    }

    /**
     * @return string
     * @throws LocalizedException
     */
    public function getButtonHtml()
    {
        $activeButton = $this->getLayout()
            ->createBlock(\Magento\Backend\Block\Widget\Button::class)
            ->setData([
                'id'      => 'magepow_module_active',
                'label'   => __('Activate Now'),
                'onclick' => 'javascript:magepowModuleActive(); return false;',
            ]);

        $cancelButton = $this->getLayout()
            ->createBlock(\Magento\Backend\Block\Widget\Button::class)
            ->setData([
                'id'      => 'magepow_module_update',
                'label'   => __('Update this license'),
                'onclick' => 'javascript:magepowModuleUpdate(); return false;',
            ]);

        return $activeButton->toHtml() . $cancelButton->toHtml();
    }

    /**
     * Render button
     *
     * @param AbstractElement $element
     *
     * @return string
     */
    public function render(AbstractElement $element)
    {
        // Remove scope label
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();

        return parent::render($element);
    }

    /**
     * @return string
     */
    public function getButtonUrl()
    {
        return '';
    }

    /**
     * Return element html
     *
     * @param AbstractElement $element
     *
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        $originalData = $element->getOriginalData();
        $path = explode('/', $originalData['path']);
        $this->addData(
            [
                'mp_is_active'       => $this->_helper->isModuleActive($originalData['module_name']),
                'mp_module_name'     => $originalData['module_name'],
                'mp_module_type'     => $originalData['module_type'],
                'mp_active_url'      => $this->getUrl('mpcore/index/activate'),
                'mp_free_config'     => Validate::jsonEncode($this->_helper->getConfigValue('free/module') ?: []),
                'mp_module_html_id'  => implode('_', $path),
                'mp_module_checkbox' => $this->_helper->getModuleCheckbox($originalData['module_name'])
            ]
        );

        return $this->_toHtml();
    }
}
