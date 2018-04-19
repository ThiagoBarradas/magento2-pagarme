<?php

namespace PagarMe\PagarMe\Api;

interface InstallmentsByBrandManagementInterface
{
    /**
     * @param mixed $brand
     * @return mixed
     */
    public function getInstallmentsByBrand($brand);

}
