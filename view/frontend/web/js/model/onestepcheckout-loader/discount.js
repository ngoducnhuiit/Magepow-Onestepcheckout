
define(
    [
        'ko'
    ],
    function (ko) {
        'use strict';

        return {
            isLoading: ko.observable(false),

            /**
             * Start full page loader action
             */
            startLoader: function () {
                this.isLoading(true);
            },
            /**
             * Stop full page loader action
             */
            stopLoader: function () {
                this.isLoading(false);
            }
        };
    }
);
