<?php
namespace Magepow\OnestepCheckout\Block\Order\View;

use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;


class Survey extends Template
{

    protected $_coreRegistry = null;

    public function __construct(
        Context $context,
        Registry $registry,
        array $data = []
    )
    {
        $this->_coreRegistry = $registry;

        parent::__construct($context, $data);
    }


    public function getSurveyQuestion()
    {
        if ($order = $this->getOrder()) {
            return $order->getSurveyQuestion();
        }

        return '';
    }

    public function getSurveyAnswers()
    {
        if ($order = $this->getOrder()) {
            return $order->getSurveyAnswers();
        }

        return '';
    }

    public function getOrder()
    {
        return $this->_coreRegistry->registry('current_order');
    }
}
