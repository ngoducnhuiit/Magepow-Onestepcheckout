

define(
    [
        'jquery',
        'ko',
        'uiComponent',
        'Magento_Checkout/js/model/quote',
        'Magento_Checkout/js/model/totals',
        'Magento_Catalog/js/price-utils',
        'Magepow_OnestepCheckout/js/action/gift-wrap'
    ],
    function ($,
              ko,
              Component,
              quote,
              totals,
              priceUtils,
              giftWrapAction) {
        "use strict";

        return Component.extend({
            defaults: {
                template: 'Magepow_OnestepCheckout/review/gift-wrap'
            },
            quoteIsVirtual: quote.isVirtual(),
            initialAmount: ko.computed(function () {
                var gwAmount = 0;

                var gwSegment = totals.getSegment('onestepcheckout_gift_wrap');
                if (gwSegment && gwSegment.extension_attributes) {
                    gwAmount = gwSegment.extension_attributes.gift_wrap_amount;
                }

                if (gwAmount >= 0) {
                    return priceUtils.formatPrice(gwAmount, quote.getPriceFormat());
                }

                return '';
            }),
            initObservable: function () {
                this._super()
                    .observe({
                        isUseGiftWrap: window.checkoutConfig.mageConfig.isUsedGiftWrap
                    });

                this.isUseGiftWrap.subscribe(function (newValue) {
                    var payload = {
                        is_use_gift_wrap: newValue
                    };

                    giftWrapAction(payload);
                });

                return this;
            }
        });
    }
);
