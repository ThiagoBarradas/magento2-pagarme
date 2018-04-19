<?php

namespace PagarMe\PagarMe\Api;

interface InstallmentsByBrandAndAmountManagementInterface
{
    /**
     * @param mixed $brand
     * @param mixed $amount
     * @return mixed
     */
    public function getInstallmentsByBrandAndAmount($brand, $amount);

}
