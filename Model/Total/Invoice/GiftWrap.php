<?php

namespace Magepow\OnestepCheckout\Model\Total\Invoice;

use Magento\Sales\Model\Order\Invoice;
use Magento\Sales\Model\Order\Invoice\Total\AbstractTotal;

/**
 * Class GiftWrap
 * @package Magepow\OnestepCheckout\Model\Total\Invoice
 */
class GiftWrap extends AbstractTotal
{
    /**
     * @param \Magento\Sales\Model\Order\Invoice $invoice
     * @return $this
     */
    public function collect(Invoice $invoice)
    {
        $order = $invoice->getOrder();
        if ($order->getGiftWrapAmount() < 0.0001) {
            return $this;
        }

        $totalGiftWrapAmount     = 0;
        $totalBaseGiftWrapAmount = 0;

        if ($order->getGiftWrapType() == \Magepow\OnestepCheckout\Model\System\Config\Source\Giftwrap::PER_ITEM) {
            foreach ($invoice->getAllItems() as $item) {
                $orderItem = $item->getOrderItem();
                if ($orderItem->isDummy() || ($orderItem->getGiftWrapAmount() < 0.001)) {
                    continue;
                }
                $rate = $item->getQty() / $orderItem->getQtyOrdered();

                $totalBaseGiftWrapAmount += $orderItem->getBaseGiftWrapAmount() * $rate;
                $totalGiftWrapAmount     += $orderItem->getGiftWrapAmount() * $rate;
            }
        } else {
            $invoiceCollections = $order->getInvoiceCollection();
            if ($invoiceCollections->getSize() == 0) {
                $totalGiftWrapAmount     = $order->getGiftWrapAmount();
                $totalBaseGiftWrapAmount = $order->getBaseGiftWrapAmount();
            }
        }
        $invoice->setBaseGiftWrapAmount($totalBaseGiftWrapAmount);
        $invoice->setGiftWrapAmount($totalGiftWrapAmount);

        $invoice->setGrandTotal($invoice->getGrandTotal() + $totalGiftWrapAmount);
        $invoice->setBaseGrandTotal($invoice->getBaseGrandTotal() + $totalBaseGiftWrapAmount);

        return $this;
    }
}
