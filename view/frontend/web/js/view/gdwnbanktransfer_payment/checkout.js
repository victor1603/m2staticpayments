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
                type: 'gdwnbanktransfer_payment',
                component: 'CodeCustom_StaticPayment/js/view/gdwnbanktransfer_payment/method-renderer/gdwnbanktransfer_payment'
            }
        );
        /** Add view logic here if needed */
        return Component.extend({});
    }
);
