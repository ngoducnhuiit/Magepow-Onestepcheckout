
define([
    'mage/storage',
    'Magepow_OnestepCheckout/js/model/resource-url-manager',
    'Magento_Checkout/js/model/quote'
], function (storage, resourceUrlManager, quote) {
    'use strict';

    return function (email) {
        return storage.post(
            resourceUrlManager.getUrlForCheckIsEmailAvailable(quote),
            JSON.stringify({
                customerEmail: email
            }),
            true
        );
    };

});
