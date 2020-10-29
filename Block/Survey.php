<?php
namespace Magepow\OnestepCheckout\Block;

use Magento\Checkout\Model\Session;
use Magento\Framework\View\Element\Template;
use Magepow\OnestepCheckout\Helper\Data;

class Survey extends Template
{
    /**
     * @var Data
     */
    protected $dataHelper;

    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $_checkoutSession;

    /**
     * @param Template\Context $context
     * @param Data $dataHelper
     * @param Session $checkoutSession
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        Data $dataHelper,
        Session $checkoutSession,
        array $data = []
    )
    {
        $this->dataHelper       = $dataHelper;
        $this->_checkoutSession = $checkoutSession;

        parent::__construct($context, $data);
        $this->getLastOrderId();
    }

    /**
     * @return bool
     */
    public function isEnableSurvey()
    {
        return $this->dataHelper->isEnabled() && !$this->dataHelper->isDisableSurvey();
    }

    public function getLastOrderId()
    {
        $orderId = $this->_checkoutSession->getLastRealOrder()->getEntityId();
        $this->_checkoutSession->setData(['survey' => ['orderId' => $orderId]]);
    }

    /**
     * @return mixed
     */
    public function getSurveyQuestion()
    {
        return $this->dataHelper->getSurveyQuestion();
    }

    /**
     * @return mixed
     */
    public function isAllowCustomerAddOtherOption()
    {
        return $this->dataHelper->isAllowCustomerAddOtherOption();
    }

    /**
     * @return array
     */
    public function getAllSurveyAnswer()
    {
        $answers = [];
        foreach ($this->dataHelper->getSurveyAnswers() as $key => $item) {
            $answers[] = ['id' => $key, 'value' => $item['value']];
        }

        return $answers;
    }
}
