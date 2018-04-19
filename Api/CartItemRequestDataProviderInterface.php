<?php
/**
 * Class CartItemRequestProvider
 *
 * @author      PagarMe Modules Team <modules@pagar.me>
 * @copyright   2018 PagarMe (http://pagar.me)
 * @license     http://pagar.me Copyright
 *
 * @link        http://pagar.me
 */

namespace PagarMe\PagarMe\Api;


interface CartItemRequestDataProviderInterface
{
    /**
     * @return string
     */
    public function getDescription();

    /**
     * @return string
     */
    public function getItemReference();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return int
     */
    public function getQuantity();

    /**
     * @return float
     */
    public function getUnitCostInCents();

    /**
     * @return float
     */
    public function getTotalCostInCents();
}
