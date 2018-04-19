<?php

namespace PagarMe\PagarMe\Model\Enum;

/**
 * Class PersonTypeEnum
 * @package PagarMe\PagarMe\Model\Enum
 */
abstract class PersonTypeEnum
{
    /**
     * Pessoa física
     */
    const PERSON = "Person";

    /**
     * Pessoa jurídica
     */
    const COMPANY = "Company";
}