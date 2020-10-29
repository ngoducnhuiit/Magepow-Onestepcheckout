<?php

namespace Magepow\OnestepCheckout\Model;

use Magepow\OnestepCheckout\Helper\Data;

/**
 * Class AgreementsValidator
 * @package Magepow\OnestepCheckout\Model
 */
class AgreementsValidator extends \Magento\CheckoutAgreements\Model\AgreementsValidator
{
    /**
     * @var Data
     */
    protected $dataHelper;

    /**
     * AgreementsValidator constructor.
     * @param Data $dataHelper
     * @param null $list
     */
    public function __construct(
        Data $dataHelper,
        $list = null
    )
    {
        parent::__construct($list);
        $this->dataHelper = $dataHelper;
    }

    /**
     * @param array $agreementIds
     * @return bool
     */
    public function isValid($agreementIds = [])
    {
        if (!$this->dataHelper->isEnabledTOC()) {
            return true;
        }

        return parent::isValid($agreementIds);
    }
}
