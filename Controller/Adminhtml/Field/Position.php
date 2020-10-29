<?php
namespace Magepow\OnestepCheckout\Controller\Adminhtml\Field;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Position
 * @package Magepow\OnestepCheckout\Controller\Adminhtml\Field
 */
class Position extends Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        /**
         * Set active menu item
         */
        $resultPage->setActiveMenu('Magepow_OnestepCheckout::field_management');
        $resultPage->getConfig()->getTitle()->prepend(__('Manage Fields'));

        /**
         * Add breadcrumb item
         */
        $resultPage->addBreadcrumb(__('One Step Checkout'), __('One Step Checkout'));
        $resultPage->addBreadcrumb(__('Manage Fields'), __('Manage Fields'));

        return $resultPage;
    }
}
