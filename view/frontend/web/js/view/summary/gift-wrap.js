

define(
    [
        'ko',
        'Magento_Checkout/js/view/summary/abstract-total',
        'Magento_Checkout/js/model/quote',
        'Magento_Checkout/js/model/totals',
        'Magepow_OnestepCheckout/js/model/one-step-checkout-data'
    ],
    function (ko, Component, quote, totals, OneStepCheckoutData) {
        "use strict";

        return Component.extend({
            defaults: {
                template: 'Magepow_OnestepCheckout/summary/gift-wrap'
            },
            totals: quote.getTotals(),
            isDisplay: function () {
                return this.getPureValue() >= 0 && OneStepCheckoutData.getData('is_use_gift_wrap');
            },
            getPureValue: function () {
                var giftWrapAmount = 0;

                if (this.totals() && totals.getSegment('onestepcheckout_gift_wrap')) {
                    giftWrapAmount = parseFloat(totals.getSegment('onestepcheckout_gift_wrap').value);
                }

                return giftWrapAmount;
            },
            getValue: function () {
                return this.getFormattedPrice(this.getPureValue());
            }
        });
    }
);
