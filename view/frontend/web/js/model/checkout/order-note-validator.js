define(
    [
        'jquery',
        'Magento_Customer/js/model/customer',
        'mage/url',
        'Magento_Checkout/js/model/error-processor',
        'Magento_Checkout/js/model/quote',
        'Magento_Checkout/js/model/url-builder'
    ],
    function ($, customer, urlFormatter, errorProcessor, quote, urlBuilder ) {
        'use strict';

        return {

            /**
             * Make an ajax PUT request to store the order note text in the quote.
             *
             * @returns {Boolean}
             */
            validate: function () {
                var isCustomer = customer.isLoggedIn();
                var form = $('#ordernote').find('form.order-note-form');
                var quoteId = quote.getQuoteId();
                var url;

                if (isCustomer) {
                    url = urlBuilder.createUrl('/carts/mine/save-order-note', {})
                } else {
                    url = urlBuilder.createUrl('/guest-carts/:cartId/save-order-note', {cartId: quoteId});
                }
                var payload = {
                    cartId: quoteId,
                    orderNote: {
                        orderNote: form.find('.input-text.order-note').val()
                    }
                };
                if (!payload.orderNote.orderNote) {
                    return true;
                }
                var result = true;

                $.ajax({
                    url: urlFormatter.build(url),
                    data: JSON.stringify(payload),
                    contentType: 'application/json',
                    type: 'PUT',
                    async: false,
                    global: false
                }).done(
                    function (response) {
                        result = true;
                    }
                ).fail(
                    function (response) {
                        result = false;
                        errorProcessor.process(response);
                    }
                );
                return result;
            }
        };
    }
);