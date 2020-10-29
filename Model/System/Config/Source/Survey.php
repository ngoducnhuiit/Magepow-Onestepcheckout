<?php
namespace Magepow\OnestepCheckout\Model\System\Config\Source;

use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\Data\Form\Element\Factory;


class Survey extends AbstractFieldArray
{
    /**
     * @var Factory
     */
    protected $_elementFactory;

    /**
     * @param Context $context
     * @param Factory $elementFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        Factory $elementFactory,
        array $data = []
    )
    {
        $this->_elementFactory = $elementFactory;
        parent::__construct($context, $data);
    }

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->addColumn('value', ['label' => __('Options')]);
        $this->_addAfter       = false;
        $this->_addButtonLabel = __('Add');
        parent::_construct();
    }
}
