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

class Cctype extends \Magento\Payment\Model\Source\Cctype
{
    /**
     * @return array
     */
    public function getAllowedTypes()
    {
        return [
			'Visa',
			'Mastercard',
			'Amex',
			'Hipercard',
			'Diners',
			'Elo',
			'Discover',
			'Aura',
			'JCB',
			'Credz',
			'SodexoAlimentacao',
			'SodexoCultura',
			'SodexoGift',
			'SodexoPremium',
			'SodexoRefeicao',
			'SodexoCombustivel',
			'VR',
			'Alelo',
			'Banese',
			'Cabal',
        ];
    }
}
