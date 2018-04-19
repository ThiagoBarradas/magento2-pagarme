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
        'Magento_Checkout/js/model/url-builder',
        'mage/url'
    ],
    function (
        $,
        storage,
        urlBuilder,
        mageUrl
    ) {
        'use strict';

        return function (data) {
            var serviceUrl;
            serviceUrl = urlBuilder.createUrl('/pagarme/customer/create/', {});

            return $.ajax({
                method: "POST",
                beforeSend: function(request) {
                    request.setRequestHeader("Content-type", 'application/json');
                },
                url: mageUrl.build(serviceUrl),
                cache: false,
                data: JSON.stringify(data)
            });
        };
    }
);
