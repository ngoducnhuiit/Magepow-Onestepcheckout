<?php
namespace Magepow\OnestepCheckout\Block;

use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Cms\Api\BlockRepositoryInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magepow\OnestepCheckout\Helper\Data;
use Magepow\OnestepCheckout\Model\System\Config\Source\StaticBlockPosition;

class StaticBlock extends Template
{
    /**
     * @var Data
     */
    protected $dataHelper;

    /**
     * @type CheckoutSession
     */
    private $checkoutSession;

    /**
     * @var BlockRepositoryInterface
     */
    protected $blockRepository;

    /**
     * StaticBlock constructor.
     * @param Context $context
     * @param Data $dataHelper
     * @param CheckoutSession $checkoutSession
     * @param BlockRepositoryInterface $blockRepository
     * @param array $data
     */
    public function __construct(
        Context $context,
        Data $dataHelper,
        CheckoutSession $checkoutSession,
        BlockRepositoryInterface $blockRepository,
        array $data = []
    )
    {
        parent::__construct($context, $data);

        $this->dataHelper      = $dataHelper;
        $this->checkoutSession = $checkoutSession;
        $this->blockRepository = $blockRepository;
    }

    /**
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getStaticBlock()
    {
        $result = [];

        $config = $this->dataHelper->isEnableStaticBlock() ? $this->dataHelper->getStaticBlockList() : [];
        foreach ($config as $key => $row) {
            /** @var \Magento\Cms\Block\Block $block */
            $block = $this->getLayout()->createBlock('Magento\Cms\Block\Block')->setBlockId($row['block'])->toHtml();
            if (($row['position'] == StaticBlockPosition::SHOW_IN_SUCCESS_PAGE && $this->getNameInLayout() == 'onestepcheckout.static-block.success')
                || ($row['position'] == StaticBlockPosition::SHOW_AT_TOP_CHECKOUT_PAGE && $this->getNameInLayout() == 'onestepcheckout.static-block.top')
                || ($row['position'] == StaticBlockPosition::SHOW_AT_BOTTOM_CHECKOUT_PAGE && $this->getNameInLayout() == 'onestepcheckout.static-block.bottom')) {
                $result[] = [
                    'content'   => $block,
                    'sortOrder' => $row['sort_order']
                ];
            }
        }

        usort($result, function ($a, $b) {
            return ($a['sortOrder'] <= $b['sortOrder']) ? -1 : 1;
        });

        return $result;
    }
}
