

/*jshint browser:true jquery:true*/
/*global alert*/
define(
    [
        'jquery',
        'ko',
        'uiComponent',
        'Magento_Customer/js/action/login',
        'Magento_Customer/js/model/customer',
        'mage/translate',
        'Magento_Ui/js/modal/modal',
        'Magento_Checkout/js/model/authentication-messages',
        'mage/validation'
    ],
    function ($, ko, Component, loginAction, customer, $t, modal, messageContainer) {
        'use strict';

        var checkoutConfig = window.checkoutConfig;
        var emailElement = ('.popup-authentication #login-email'),
            passwordElement = ('.popup-authentication #login-password');

        return Component.extend({
            registerUrl: checkoutConfig.registerUrl,
            forgotPasswordUrl: checkoutConfig.forgotPasswordUrl,
            autocomplete: checkoutConfig.autocomplete,
            modalWindow: null,
            isLoading: ko.observable(false),

            defaults: {
                template: 'Magepow_OnestepCheckout/authentication'
            },

            /**
             * Init
             */
            initialize: function () {
                var self = this;
                this._super();
                loginAction.registerLoginCallback(function () {
                    self.isLoading(false);
                });
            },

            setModalElement: function (element) {
                this.modalWindow = element;
                var options = {
                    'type': 'popup',
                    'title': $t('Sign In'),
                    'modalClass': 'popup-authentication',
                    'responsive': true,
                    'innerScroll': true,
                    'trigger': '.onestepcheckout-authentication-toggle',
                    'buttons': []
                };
                if (window.checkoutConfig.mageConfig.isDisplaySocialLogin && $("#social-login-popup").length > 0) {
                    this.modalWindow = $("#social-login-popup");
                    options.modalClass = 'onestepcheckout-social-login-popup';
                }
                modal(options, $(this.modalWindow));
            },

            isActive: function () {
                return !customer.isLoggedIn();
            },

            showModal: function () {
                $(this.modalWindow).modal('openModal');
            },


            login: function (loginForm) {
                var loginData = {},
                    formDataArray = $(loginForm).serializeArray();
                formDataArray.forEach(function (entry) {
                    loginData[entry.name] = entry.value;
                });

                if ($(loginForm).validation() &&
                    $(loginForm).validation('isValid')
                ) {
                    this.isLoading(true);
                    loginAction(loginData, null, false, messageContainer)
                        .done(function (response) {
                            if (!response.errors) {
                                messageContainer.addSuccessMessage({'message': $t('Login successfully.')});
                            }
                        });
                }
            },

            hasValue: function () {
                if (window.checkoutConfig.mageConfig.isUsedMaterialDesign) {
                    $(emailElement).val() ? $(emailElement).addClass('active') : $(emailElement).removeClass('active');
                    $(passwordElement).val() ? $(passwordElement).addClass('active') : $(passwordElement).removeClass('active');
                }
            }
        });
    }
);
