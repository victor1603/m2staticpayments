define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (
        Component,
        rendererList
    ) {
        'use strict';
        rendererList.push(
            {
                type: 'gdwncash_payment',
                component: 'CodeCustom_StaticPayment/js/view/gdwncash_payment/method-renderer/gdwncash_payment'
            }
        );
        /** Add view logic here if needed */
        return Component.extend({});
    }
);
