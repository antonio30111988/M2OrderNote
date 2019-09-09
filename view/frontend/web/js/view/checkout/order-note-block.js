define(
    [
        'jquery',
        'uiComponent',
        'Magento_Customer/js/model/customer'
    ],
    function ($, Component, customer) {
        'use strict';

        return Component.extend({
            defaults: {
                template: 'Antonio88_OrderNote/checkout/order-note-block'
            },
            isCustomerLoggedIn: customer.isLoggedIn,
            initialize: function () {
                this._super();
                $( document ).ready(function() {
                    setTimeout(function(){
                        $("#noteCode").val(window.checkoutConfig.defaultOrderNote);
                    }, 3000);
                });
            }
        });
    }
);
