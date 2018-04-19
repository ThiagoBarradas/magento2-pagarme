<?php
/**
 * Class CustomerAddressInterface
 *
 * @author      PagarMe Modules Team <modules@pagar.me>
 * @copyright   2018 PagarMe (http://pagar.me)
 * @license     http://pagar.me Copyright
 *
 * @link        http://pagar.me
 */

namespace PagarMe\PagarMe\Helper;


interface CustomerAddressInterface
{
    const PATH_STREET_ATTRIBUTE         = 'pagarme/pagarme_customer_address/street_attribute';
    const PATH_NUMBER_ATTRIBUTE         = 'pagarme/pagarme_customer_address/number_attribute';
    const PATH_COMPLEMENT_ATTRIBUTE     = 'pagarme/pagarme_customer_address/complement_attribute';
    const PATH_DISTRICT_ATTRIBUTE       = 'pagarme/pagarme_customer_address/district_attribute';

    /**
     * @return string
     */
    public function getStreetAttribute();

    /**
     * @return string
     */
    public function getNumberAttribute();

    /**
     * @return string
     */
    public function getComplementAttribute();

    /**
     * @return string
     */
    public function getDistrictAttribute();
}
