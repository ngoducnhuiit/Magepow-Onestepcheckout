<?php
namespace Magepow\OnestepCheckout\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;

/**
 * Class Userguide
 * @package Magepow\OnestepCheckout\Controller\Adminhtml\Index
 */
class Userguide extends Action
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Magepow_OnestepCheckout::userguide';

    /**
     * @return ResponseInterface|ResultInterface|void
     */
    public function execute()
    {
        $this->_response->setRedirect(
            'https://docs.magepow.com/?utm_source=configuration&utm_medium=link&utm_content=user-guide'
        );
    }
}
