<?php
namespace Magepow\OnestepCheckout\Model\Message;

use Magento\Framework\Notification\MessageInterface;
use Magento\Framework\Phrase;
use Magento\Framework\UrlInterface;
use Magepow\OnestepCheckout\Helper\Validate as ValidateHelper;

/**
 * Class Validate
 * @package Magepow\OnestepCheckout\Model\Message
 */
class Validate implements MessageInterface
{
    /**
     * @var ValidateHelper
     */
    protected $_helper;

    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var array
     */
    protected $_needActiveModules = [];

    /**
     * Validate constructor.
     *
     * @param ValidateHelper $helper
     * @param UrlInterface $urlBuilder
     */
    public function __construct(
        ValidateHelper $helper,
        UrlInterface $urlBuilder
    ) {
        $this->_helper = $helper;
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * Check whether all extensions are valid or not
     *
     * @return bool
     */
    public function isDisplayed()
    {
        $notActiveModules = $this->getModules();

        return (bool) count($notActiveModules);
    }

    /**
     * @return array
     */
    public function getModules()
    {
        if (empty($this->_needActiveModules)) {
            $moduleLists = $this->_helper->getModuleList();
            foreach ($moduleLists as $module) {
                if ($this->_helper->needActive($module) && !$this->_helper->isModuleActive($module)) {
                    $this->_needActiveModules[] = $module;
                }
            }
        }

        return $this->_needActiveModules;
    }

    /**
     * Retrieve unique message identity
     *
     * @return string
     */
    public function getIdentity()
    {
        return hash('md5', 'MAGEPOW_VALIDATE_MESSAGE');
    }

    /**
     * Retrieve message text
     *
     * @return Phrase|string
     */
    public function getText()
    {
        $modules = $this->getModules();
        if (empty($modules)) {
            return '';
        }

        $sectionName = $this->_helper->getConfigModulePath($modules[0]);
        $url = $this->urlBuilder->getUrl('adminhtml/system_config/edit', ['section' => $sectionName]);

        return __(
            'One or more Magepow extensions are not validated. Click <a href="%1">here</a> to validate them.',
            $url
        );
    }

    /**
     * Retrieve message severity
     *
     * @return int
     */
    public function getSeverity()
    {
        return self::SEVERITY_MAJOR;
    }
}
