

define([
    'Magento_Ui/js/form/element/abstract',
    'Magepow_OnestepCheckout/js/model/address/google-auto-complete'
], function (Component, googleAutoComplete) {
    'use strict';

    return Component.extend({

        googleAutocomplete: null,

        /**
         * Invokes initialize method of parent class,
         * contains initialization logic
         */
        initialize: function () {
            this._super()
                .initAutocomplete();

            return this;
        },

        initAutocomplete: function () {
            var fieldsetName = this.parentName.split('.').slice(0, -1).join('.');

            switch (window.checkoutConfig.mageConfig.autocomplete.type) {
                case 'google':
                    this.googleAutocomplete = new googleAutoComplete(this.uid, fieldsetName);
                    break;
                case 'pca':
                    break;
                default :
                    break;
            }

            return this;
        }
    });
});
