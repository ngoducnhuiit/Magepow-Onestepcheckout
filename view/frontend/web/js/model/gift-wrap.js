

define(['ko'], function (ko) {
    'use strict';
    var hasWrap = ko.observable(window.checkoutConfig.mageConfig.giftWrap.hasWrap);
    return {
        hasWrap: hasWrap,
        getIsWrap: function () {
            return this.hasWrap();
        },
        setIsWrap: function (isWrap) {
            return this.hasWrap(isWrap);
        }
    };
});
