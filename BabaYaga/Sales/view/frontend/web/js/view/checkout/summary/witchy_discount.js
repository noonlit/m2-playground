define(
    [
        'Magento_Checkout/js/view/summary/abstract-total',
        'Magento_Checkout/js/model/quote',
        'Magento_Catalog/js/price-utils',
        'Magento_Checkout/js/model/totals'
    ],
    function (Component, quote, priceUtils, totals) {
        "use strict";

        return Component.extend({
            defaults: {
                isFullTaxSummaryDisplayed: window.checkoutConfig.isFullTaxSummaryDisplayed || false,
                template: 'BabaYaga_Sales/checkout/summary/witchy_discount'
            },

            totals: quote.getTotals(),

            isTaxDisplayedInGrandTotal: window.checkoutConfig.includeTaxInGrandTotal || false,

            /**
             * @returns {*|boolean}
             */
            isDisplayed: function () {
                return this.isFullMode() && this.getNumericValue() !== 0;
            },

            /**
             * Returns a value like "-$10.00"
             * @returns {*|String}
             */
            getValue: function () {
                return this.getFormattedPrice(this.getNumericValue());
            },

            /**
             * Returns a value like -10
             *
             * @returns {number}
             */
            getNumericValue: function () {
                let price = 0;

                if (this.totals()) {
                    price = totals.getSegment('witchy_discount').value;
                }

                return price;
            }
        });
    }
);
