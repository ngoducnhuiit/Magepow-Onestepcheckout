<?php

namespace Magepow\OnestepCheckout\Controller\Adminhtml\System\Config;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Controller\Result\JsonFactory;
use Magepow\OnestepCheckout\Helper\Data;

class Geoip extends Action
{

    protected $resultJsonFactory;

    protected $_directoryList;

    protected $dataHelper;

    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        DirectoryList $directoryList,
        Data $dataHelper
    )
    {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->_directoryList    = $directoryList;
        $this->dataHelper        = $dataHelper;

        parent::__construct($context);
    }

    /**
     * @return $this|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $status = false;
        try {
            $path = $this->_directoryList->getPath('var') . '/Magepow/OnestepCheckout/GeoIp';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $folder   = scandir($path, true);
            $pathFile = $path . '/' . $folder[0] . '/GeoLite2-City.mmdb';
            if (file_exists($pathFile)) {
                foreach (scandir($path . '/' . $folder[0], true) as $filename) {
                    if ($filename == '..' || $filename == '.') {
                        continue;
                    }
                    @unlink($path . '/' . $folder[0] . '/' . $filename);
                }
                @rmdir($path . '/' . $folder[0]);
            }

            file_put_contents($path . '/GeoLite2-City.tar.gz', fopen($this->dataHelper->getDownloadPath(), 'r'));
            $phar = new \PharData($path . '/GeoLite2-City.tar.gz');
            $phar->extractTo($path);
            $status  = true;
            $message = __("Download library success!");
        } catch (\Exception $e) {
            $message = __("Can't download file. Please try again! %1", $e->getMessage());
        }

        /** @var \Magento\Framework\Controller\Result\Json $result */
        $result = $this->resultJsonFactory->create();

        return $result->setData(['success' => $status, 'message' => $message]);
    }
}
