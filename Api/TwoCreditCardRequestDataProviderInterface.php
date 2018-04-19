<?php
/**
 * Class CreateBilletCreditCardDataProviderInterface
 *
 * @author      PagarMe Modules Team <modules@pagar.me>
 * @copyright   2018 PagarMe (http://pagar.me)
 * @license     http://pagar.me Copyright
 *
 * @link        http://pagar.me
 */

namespace PagarMe\PagarMe\Api;


interface TwoCreditCardRequestDataProviderInterface extends BaseRequestDataProviderInterface
{

    /**
     * @return int
     */
    public function getInstallmentCount();

    /**
     * @return string
     */
    public function getTokenCreditCardFirst();

    /**
     * @return string
     */
    public function getTokenCreditCardSecond();

    /**
     * @return int
     */
    public function getSaveCard();
    
    /**
     * @return string
     */
    public function getBilletCreditCardOperation();

    /**
     * @return string
     */
    public function getBilletCreditCardBrand();

    /**
     * @return string
     */
    public function getBilletCreditCardNumber();

    /**
     * @return string
     */
    public function getExpMonth();

    /**
     * @return string
     */
    public function getExpYear();

    /**
     * @return string
     */
    public function getHolderName();

    /**
     * @return string
     */
    public function getSecurityCode();

    /**
     * @return string
     */
    public function getIsOneDollarAuthEnabled();

    /**
     * @return string
     */
    public function getCustomerAddressStreet($shipping);

    /**
     * @return string
     */
    public function getCustomerAddressNumber($shipping);

    /**
     * @return string
     */
    public function getCustomerAddressComplement($shipping);

    /**
     * @return string
     */
    public function getCustomerAddressDistrict($shipping);
}
