<?php


namespace Magepow\OnestepCheckout\Block\LayoutOnestep;

use Magento\Framework\View\Element\Template;
use Magepow\OnestepCheckout\Helper\Data;

class CompatibleConfig extends Template
{
    /**
     * @var string $_template
     */
    protected $_template = "onepage/compatible-config.phtml";

    /**
     * @var Data
     */
    protected $dataHelper;

    /**
     * CompatibleConfig constructor.
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
        parent::__construct($context, $data);

        $this->dataHelper = $dataHelper;
    }

    /**
     * @return bool
     */
    public function isEnableModulePostNL()
    {
        return $this->dataHelper->isEnableModulePostNL();
    }
}
