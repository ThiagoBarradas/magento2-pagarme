/**
 * @author      PagarMe Modules Team <modules@pagar.me>
 * @copyright   2018 PagarMe (http://pagar.me)
 * @license     http://pagar.me  Copyright
 *
 * @link        http://pagar.me
 */
/*browser:true*/
/*global define*/
define(
    [
        'jquery',
        'mage/storage',
        'Magento_Checkout/js/model/url-builder'
    ],
    function (
        $,
        storage,
        urlBuilder
    ) {
        'use strict';

        return function (dataJson) {
            var serviceUrl = 'https://api.mundipagg.com/core/v1/tokens?appId=' + window.checkoutConfig.payment.ccform.pk_token;

            return $.ajax({
                method: "POST",
                url: serviceUrl,
                cache: false,
                data: dataJson
            });
        };
    }
);
