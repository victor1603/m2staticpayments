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
                type: 'gdwn_banktransfer_payment',
                component: 'CodeCustom_StaticPayment/js/view/gdwn_banktransfer_payment/method-renderer/gdwn_banktransfer_payment'
            }
        );
        /** Add view logic here if needed */
        return Component.extend({});
    }
);
