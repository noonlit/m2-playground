define(
   [
       'BabaYaga_Sales/js/view/checkout/summary/witchy_discount'
   ],
   function (Component) {
       'use strict';
       return Component.extend({
           /**
            * @override
            */
           isDisplayed: function () {
               return this.getNumericValue() !== 0;
           }
       });
   }
);
