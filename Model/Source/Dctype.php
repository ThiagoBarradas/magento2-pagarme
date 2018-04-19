<?php

namespace PagarMe\PagarMe\Model\Source;

/**
 * CC Types
 *
 * @author      PagarMe Modules Team <modules@pagar.me>
 * @copyright   2018 PagarMe (http://pagar.me)
 * @license     http://pagar.me  Copyright
 *
 * @link        http://pagar.me
 */

class Dctype extends \Magento\Payment\Model\Source\Cctype
{
    /**
     * @return array
     */
    public function getAllowedTypes()
    {
        return [
            'Simulado',
            'Cielo-Visa',
            'Cielo-Master',
            'Cielo-Elo',
            'Redecard-Visa',
            'Redecard-Master'
        ];
    }
}
