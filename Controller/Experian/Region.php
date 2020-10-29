<?php
/**
 * Region
 *
 * @copyright Copyright © 2020 Magepow. All rights reserved.
 * @author    @copyright Copyright (c) 2014 Magepow (<https://www.magepow.com>)
 * @license <https://www.magepow.com/license-agreement.html>
 * @Author: magepow<support@magepow.com>
 * @github: <https://github.com/magepow>
 */

namespace Magepow\OnestepCheckout\Controller\Experian;
use Magento\Directory\Model\ResourceModel\Region\CollectionFactory;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Serialize\SerializerInterface;

class Region extends Magento\Framework\App\Action\Action
{
    private $collectionFactory;
    public function __construct(Context $context,
                                CollectionFactory $collectionFactory

    ) {
        parent::__construct($context);
        $this->collectionFactory = $collectionFactory;
    }
    public function getRegionCodeFilter($country, $region)
    {
        $regionCode = $this->collectionFactory->create()->addCountryFilter($country)->addRegionCodeFilter($region)->getFirstItem();
        return $regionCode;
    }

    public function execute()
    {
        $countryCode = $this->getRequest()->getParam('country');
        $regionCode = $this->getRequest()->getParam('region');
        $itemRegion  = $this->getRegionCodeFilter($countryCode ,$regionCode);
        $region= [$regionCode => $itemRegion->getRegionId()];
        echo json_encode($region);

    }
}
