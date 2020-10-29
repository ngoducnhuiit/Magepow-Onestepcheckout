<?php
namespace Magepow\OnestepCheckout\Controller\Survey;
use Magento\Checkout\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Json\Helper\Data as JsonHelper;
use Magento\Sales\Model\Order;
use Magepow\OnestepCheckout\Helper\Data;


class Save extends Action
{
    /**
     * @var \Magento\Framework\Json\Helper\Data
     */
    protected $jsonHelper;

    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $_checkoutSession;

    /**
     * @var \Magento\Sales\Model\Order
     */
    protected $_order;

    /**
     * @var Data
     */
    protected $dataHelper;

    /**
     * Save constructor.
     * @param Context $context
     * @param JsonHelper $jsonHelper
     * @param Session $checkoutSession
     * @param Order $order
     * @param Data $dataHelper
     */
    public function __construct(
        Context $context,
        JsonHelper $jsonHelper,
        Session $checkoutSession,
        Order $order,
        Data $dataHelper
    )
    {
        $this->jsonHelper       = $jsonHelper;
        $this->_checkoutSession = $checkoutSession;
        $this->_order           = $order;
        $this->dataHelper        = $dataHelper;

        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|null
     */
    public function execute()
    {
        $response = [];
        if ($this->getRequest()->getParam('answerChecked') && isset($this->_checkoutSession->getData()['survey'])) {
            try {
                $order   = $this->_order->load($this->_checkoutSession->getData()['survey']['orderId']);
                $answers = '';
                foreach ($this->getRequest()->getParam('answerChecked') as $item) {
                    $answers .= $item . ' - ';
                }
                $order->setData('onestepcheckout_survey_question', $this->dataHelper->getSurveyQuestion());
                $order->setData('onestepcheckout_survey_answers', substr($answers, 0, -2));
                $order->save();

                $response['status']  = 'success';
                $response['message'] = 'Thank you for completing our survey!';
                $this->_checkoutSession->unsData();
            } catch (\Exception $e) {
                $response['status']  = 'error';
                $response['message'] = "Can't save survey answer. Please try again! ";
            }

            return $this->getResponse()->representJson(Data::jsonEncode($response));
        }

        return null;
    }
}
