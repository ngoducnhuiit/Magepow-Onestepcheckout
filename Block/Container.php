<?php


namespace Magepow\OnestepCheckout\Block;

use Magento\Framework\View\Element\Template;
use Magepow\OnestepCheckout\Helper\Data;

class Container extends Template
{
    /**
     * @var Data
     */
    protected $dataHelper;

    /**
     * Container constructor.
     * @param Template\Context $context
     * @param Data $dataHelper
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        Data $dataHelper,
        array $data = []
    )
    {
        $this->dataHelper = $dataHelper;

        parent::__construct($context, $data);
    }

    /**
     * @return mixed
     */
    public function getCheckoutDescription()
    {
        return $this->dataHelper->getConfigGeneral('description');
    }
}
