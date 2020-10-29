<?php
/**
 * StaticBlock
 *
 * @copyright Copyright © 2020 Magepow. All rights reserved.
 * @author    @copyright Copyright (c) 2014 Magepow (<https://www.magepow.com>)
 * @license <https://www.magepow.com/license-agreement.html>
 * @Author: magepow<support@magepow.com>
 * @github: <https://github.com/magepow>
 */

namespace Magepow\OnestepCheckout\Block\Adminhtml\Config\Backend;


use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\Data\Form\Element\Factory;

class StaticBlock extends AbstractFieldArray
{
    /**
     * @var \Magento\Framework\Data\Form\Element\Factory
     */
    protected $elementFactory;

    /**
     * @var \Magepow\OnestepCheckout\Model\System\Config\Source\StaticBlockPosition
     */
    protected $blockPosition;

    /**
     * @var \Magento\Cms\Model\ResourceModel\Block\CollectionFactory
     */
    protected $blockFactory;
    public function __construct(
        Context $context,
        Factory $elementFactory,
        \Magepow\OnestepCheckout\Model\System\Config\Source\StaticBlockPosition $blockPosition,
        \Magento\Cms\Model\ResourceModel\Block\CollectionFactory $blockFactory,
        array $data = []
    )
    {
        $this->elementFactory = $elementFactory;
        $this->blockPosition  = $blockPosition;
        $this->blockFactory   = $blockFactory;

        parent::__construct($context, $data);
    }

    /**
     * Initialise form fields
     *
     * @return void
     */
    public function _construct()
    {
        $this->addColumn('block', ['label' => __('Block')]);
        $this->addColumn('position', ['label' => __('Position')]);
        $this->addColumn('sort_order', ['label' => __('Sort Order'), 'style' => 'width: 100px']);
        $this->_addAfter       = false;
        $this->_addButtonLabel = __('More');

        parent::_construct();
    }

    public function renderCellTemplate($columnName)
    {
        if (!empty($this->_columns[$columnName])) {
            switch ($columnName) {
                case 'block':
                    $options = $this->blockFactory->create()->toOptionArray();
                    break;
                case 'position':
                    $options = $this->blockPosition->toOptionArray();
                    break;
                default:
                    $options = '';
                    break;
            }
            if ($options) {
                foreach ($options as $index => &$item) {
                    if (is_array($item) && isset($item['label'])) {
                        $item['label'] = addslashes($item['label']);
                    }
                }

                $element = $this->elementFactory->create('select');
                $element->setForm($this->getForm())
                    ->setName($this->_getCellInputElementName($columnName))
                    ->setHtmlId($this->_getCellInputElementId('<%- _id %>', $columnName))
                    ->setValues($options)
                    ->setStyle('width: 200px');

                return str_replace("\n", '', $element->getElementHtml());
            }
        }

        return parent::renderCellTemplate($columnName);
    }
}
