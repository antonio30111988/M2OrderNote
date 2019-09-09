define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/additional-validators',
        'Antonio88_OrderNote/js/model/checkout/order-note-validator'
    ],
    function (Component, additionalValidators, orderNoteValidator) {
        'use strict';

        additionalValidators.registerValidator(orderNoteValidator);

        return Component.extend({});
    }
);