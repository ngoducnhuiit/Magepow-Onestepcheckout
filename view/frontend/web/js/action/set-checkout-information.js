
define(
    [
        'Magento_Checkout/js/model/shipping-save-processor',
        'Magepow_OnestepCheckout/js/model/checkout'
    ],
    function (shippingSaveProcessor, Processor) {
        'use strict';

        shippingSaveProcessor.registerProcessor('onestepcheckout', Processor);

        return function () {
            return shippingSaveProcessor.saveShippingInformation('onestepcheckout');
        }
    }
);
