
define([
    'Magento_Checkout/js/view/shipping-address/address-renderer/default',
    'Magento_Checkout/js/model/shipping-rate-service'
], function (Component, shippingRateService) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Magepow_OnestepCheckout/address/shipping/address-renderer/default'
        },

        /** Set selected customer shipping address  */
        selectAddress: function () {
            if (!this.isSelected()) {
                this._super();

                shippingRateService.estimateShippingMethod();
            }
        }
    });
});
