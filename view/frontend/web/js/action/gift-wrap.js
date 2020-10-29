
define(
    [
        'Magento_Checkout/js/model/quote',
        'Magepow_OnestepCheckout/js/model/resource-url-manager',
        'mage/storage',
        'Magento_Checkout/js/model/error-processor',
        'Magento_Customer/js/model/customer',
        'Magento_Checkout/js/model/payment/method-converter',
        'Magento_Checkout/js/model/payment-service',
        'Magento_Checkout/js/model/shipping-service',
        'Magepow_OnestepCheckout/js/model/one-step-checkout-loader',
        'Magepow_OnestepCheckout/js/model/one-step-checkout-data'
    ],
    function (quote,
              resourceUrlManager,
              storage,
              errorProcessor,
              customer,
              methodConverter,
              paymentService,
              shippingService,
              OneStepCheckoutLoader,
              OneStepCheckoutData) {
        'use strict';

        var itemUpdateLoader = ['shipping', 'payment', 'total'];

        return function (payload) {
            if (!customer.isLoggedIn()) {
                payload.cart_id = quote.getQuoteId();
            }

            OneStepCheckoutLoader.startLoader(itemUpdateLoader);

            return storage.post(
                resourceUrlManager.getUrlForGiftWrapInformation(quote),
                JSON.stringify(payload)
            ).done(
                function (response) {
                    if (response.redirect_url) {
                        window.location.href = response.redirect_url;
                        return;
                    }
                    OneStepCheckoutData.setData('is_use_gift_wrap', payload.is_use_gift_wrap);
                    quote.setTotals(response.totals);
                    paymentService.setPaymentMethods(methodConverter(response.payment_methods));
                    if (response.shipping_methods && !quote.isVirtual()) {
                        shippingService.setShippingRates(response.shipping_methods);
                    }
                }
            ).fail(
                function (response) {
                    errorProcessor.process(response);
                }
            ).always(
                function () {
                    OneStepCheckoutLoader.stopLoader(itemUpdateLoader);
                }
            );
        };
    }
);
