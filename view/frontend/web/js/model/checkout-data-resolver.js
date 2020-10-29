
define(
    [
        'Magento_Checkout/js/checkout-data'
    ],
    function (checkoutData) {
        'use strict';

        return {

            /**
             * Set default shipping method to local storage
             */
            resolveDefaultShippingMethod: function () {
                if (!checkoutData.getSelectedShippingRate() && window.checkoutConfig.selectedShippingRate) {
                    checkoutData.setSelectedShippingRate(window.checkoutConfig.selectedShippingRate);
                }
            },

            /**
             * Set default payment method to local storage
             */
            resolveDefaultPaymentMethod: function () {
                if (!checkoutData.getSelectedPaymentMethod() && window.checkoutConfig.selectedPaymentMethod) {
                    checkoutData.setSelectedPaymentMethod(window.checkoutConfig.selectedPaymentMethod);
                }
            }
        }
    }
);
