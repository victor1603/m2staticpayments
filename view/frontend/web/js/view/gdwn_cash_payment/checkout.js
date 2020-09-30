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
                type: 'gdwn_cash_payment',
                component: 'CodeCustom_StaticPayment/js/view/gdwn_cash_payment/method-renderer/gdwn_cash_payment'
            }
        );
        /** Add view logic here if needed */
        return Component.extend({});
    }
);
