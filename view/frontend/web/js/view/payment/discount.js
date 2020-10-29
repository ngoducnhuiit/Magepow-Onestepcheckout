

/*jshint browser:true jquery:true*/
/*global alert*/
define(
    [
        'ko',
        'Magento_SalesRule/js/view/payment/discount',
        'Magepow_OnestepCheckout/js/model/onestepcheckout-loader/discount'
    ],
    function (ko, Component, discountLoader) {
        'use strict';

        return Component.extend({
            defaults: {
                template: 'Magepow_OnestepCheckout/review/discount'
            },
            isBlockLoading: discountLoader.isLoading
        });
    }
);
