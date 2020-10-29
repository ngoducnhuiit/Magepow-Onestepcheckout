<?php
namespace Magepow\OnestepCheckout\Model\Total\Creditmemo;

use Magento\Sales\Model\Order\Creditmemo;
use Magento\Sales\Model\Order\Creditmemo\Total\AbstractTotal;

/**
 * Class GiftWrap
 * @package Magepow\OnestepCheckout\Model\Total\Creditmemo
 */
class GiftWrap extends AbstractTotal
{
    /**
     * @param Creditmemo $creditmemo
     * @return $this
     */
    public function collect(Creditmemo $creditmemo)
    {
        $order = $creditmemo->getOrder();
        if ($order->getGiftWrapAmount() < 0.0001) {
            return $this;
        }

        $totalGiftWrapAmount     = 0;
        $totalBaseGiftWrapAmount = 0;
        if ($order->getGiftWrapType() == \Magepow\OnestepCheckout\Model\System\Config\Source\Giftwrap::PER_ITEM) {
            foreach ($creditmemo->getAllItems() as $item) {
                $orderItem = $item->getOrderItem();
                if ($orderItem->isDummy() || ($orderItem->getGiftWrapAmount() < 0.001)) {
                    continue;
                }
                $rate = $item->getQty() / $orderItem->getQtyOrdered();

                $totalBaseGiftWrapAmount += $orderItem->getBaseGiftWrapAmount() * $rate;
                $totalGiftWrapAmount     += $orderItem->getGiftWrapAmount() * $rate;
            }
        } else if ($this->isLast($creditmemo)) {
            $totalGiftWrapAmount     = $order->getGiftWrapAmount();
            $totalBaseGiftWrapAmount = $order->getBaseGiftWrapAmount();
        }

        $creditmemo->setBaseGiftWrapAmount($totalBaseGiftWrapAmount);
        $creditmemo->setGiftWrapAmount($totalGiftWrapAmount);

        $creditmemo->setGrandTotal($creditmemo->getGrandTotal() + $totalGiftWrapAmount);
        $creditmemo->setBaseGrandTotal($creditmemo->getBaseGrandTotal() + $totalBaseGiftWrapAmount);

        return $this;
    }

    /**
     * check credit memo is last or not
     *
     * @param Creditmemo $creditmemo
     * @return boolean
     */
    public function isLast($creditmemo)
    {
        foreach ($creditmemo->getAllItems() as $item) {
            if (!$item->isLast()) {
                return false;
            }
        }

        return true;
    }
}
