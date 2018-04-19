<?php
/**
 * Class InstallmentsInterface
 *
 * @author      PagarMe Modules Team <modules@pagar.me>
 * @copyright   2018 PagarMe (http://pagar.me)
 * @license     http://pagar.me Copyright
 *
 * @link        http://pagar.me
 */

namespace PagarMe\PagarMe\Api;


interface InstallmentsManagementInterface
{
    /**
     * @return array
     */
    public function getInstallments();
}
