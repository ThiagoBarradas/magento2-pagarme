<?php
/**
 * @author      PagarMe Modules Team <modules@pagar.me>
 * @copyright   2018 PagarMe (http://pagar.me)
 * @license     http://pagar.me  Copyright
 *
 * @link        http://pagar.me
 *
 */

namespace PagarMe\PagarMe\Model\Source;

class BilletTypes extends \Magento\Payment\Model\Source\Cctype
{
    /**
     * @return array
     */
    public function getAllowedTypes()
    {
        return [
            'Itau',
            'Bradesco',
            'Santander',
            'CitiBank',
            'BancoDoBrasil',
            'Caixa',
            'Stone'
        ];
    }
}
