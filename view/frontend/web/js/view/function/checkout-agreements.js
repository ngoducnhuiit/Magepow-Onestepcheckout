

define(
    [
        'Magento_CheckoutAgreements/js/view/checkout-agreements',
        'Magento_Checkout/js/model/payment/additional-validators',
        'Magepow_OnestepCheckout/js/model/agreement-validator'
    ],
    function (Component, additionalValidators, agreementValidator) {
        'use strict';

        additionalValidators.registerValidator(agreementValidator);
        return Component.extend({
        });
    }
);
