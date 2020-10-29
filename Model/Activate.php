<?php
namespace Magepow\OnestepCheckout\Model;

use Exception;
use Magento\Framework\DataObject;
use Magento\Framework\HTTP\Adapter\CurlFactory;
use Magepow\OnestepCheckout\Helper\Data;
use Zend_Http_Client;
use Zend_Http_Response;

/**
 * Class Activate
 * @package Magepow\OnestepCheckout\Model
 */
class Activate extends DataObject
{
    /**
     * Localhost maybe not active via https
     * @inheritdoc
     */
    const MAGEPOW_ACTIVE_URL = 'https://alothemes.com';

    /**
     * @var CurlFactory
     */
    protected $curlFactory;

    /**
     * Activate constructor.
     *
     * @param CurlFactory $curlFactory
     * @param array $data
     */
    public function __construct(
        CurlFactory $curlFactory,
        array $data = []
    ) {
        $this->curlFactory = $curlFactory;

        parent::__construct($data);
    }

    /**
     * @param array $params
     *
     * @return array
     */
    public function activate($params = [])
    {
        $result = ['success' => false];

        $curl = $this->curlFactory->create();
        $curl->write(
            Zend_Http_Client::POST,
            self::MAGEPOW_ACTIVE_URL,
            '1.1',
            [],
            http_build_query($params, null, '&')
        );

        try {
            $resultCurl = $curl->read();
            if (empty($resultCurl)) {
                $result['message'] = __('Cannot connect to server. Please try again later.');
            } else {
                $responseBody = Zend_Http_Response::extractBody($resultCurl);
                $result += Data::jsonDecode($responseBody);
                if (isset($result['status']) && in_array($result['status'], [200, 201])) {
                    $result['success'] = true;
                }
            }
        } catch (Exception $e) {
            $result['message'] = $e->getMessage();
        }

        $curl->close();

        return $result;
    }
}
