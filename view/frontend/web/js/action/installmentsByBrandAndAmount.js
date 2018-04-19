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
        'mage/storage',
        'Magento_Checkout/js/model/url-builder'
    ],
    function (
        storage,
        urlBuilder
    ) {
        'use strict';

        return function (brand, amount) {
            var serviceUrl;
            serviceUrl = urlBuilder.createUrl('/pagarme/installments/brandbyamount/' + brand + '/' + amount, {});

            return storage.get(
                serviceUrl, false
            )
        };
    }
);
