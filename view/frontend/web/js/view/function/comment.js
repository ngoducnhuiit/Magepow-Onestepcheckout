
define(
    [
        'ko',
        'uiComponent',
        'Magepow_OnestepCheckout/js/model/one-step-checkout-data'
    ],
    function (ko, Component, OneStepCheckoutData) {
        "use strict";

        var cacheKey = 'comment';

        return Component.extend({
            defaults: {
                template: 'Magepow_OnestepCheckout/review/comment'
            },
            commentValue: ko.observable(),
            initialize: function () {
                this._super();

                this.commentValue(OneStepCheckoutData.getData(cacheKey));

                this.commentValue.subscribe(function (newValue) {
                    OneStepCheckoutData.setData(cacheKey, newValue);
                });

                return this;
            }
        });
    }
);
