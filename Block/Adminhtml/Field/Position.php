<?php
namespace Magepow\OnestepCheckout\Block\Adminhtml\Field;
use Magento\Backend\Block\Widget\Container;
use Magento\Backend\Block\Widget\Context;
use Magepow\OnestepCheckout\Helper\Data;

/**
 * Class Position
 * @package Magepow\OnestepCheckout\Block\Adminhtml\Field
 */
class Position extends Container
{

    protected $dataHelper;

    protected $sortedFields = [];

    protected $availableFields = [];

    public function __construct(
        Context $context,
        Data $dataHelper,
        array $data = []
    )
    {
        $this->dataHelper = $dataHelper;

        parent::__construct($context, $data);
    }

    protected function _construct()
    {
        parent::_construct();

        $this->addButton(
            'save',
            [
                'label'   => __('Save Position'),
                'class'   => 'save primary',
                'onclick' => 'savePosition()'
            ],
            1
        );

        list($this->sortedFields, $this->availableFields) = $this->getHelperData()->getAddressHelper()->getSortedField(false);
    }

    /**
     * @return \Magento\Framework\Phrase|string
     */
    public function getHeaderText()
    {
        return __('Manage Fields');
    }

    public function getSortedFields()
    {
        return $this->sortedFields;
    }

    public function getAvailableFields()
    {
        return $this->availableFields;
    }

    public function getHelperData()
    {
        return $this->dataHelper;
    }

    public function getAjaxUrl()
    {
        return $this->getUrl('*/*/save');
    }
}
