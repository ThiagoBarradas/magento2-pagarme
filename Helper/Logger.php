<?php
/**
 * Class Logger
 *
 * @author      PagarMe Modules Team <modules@pagar.me>
 * @copyright   2018 PagarMe (http://pagar.me)
 * @license     http://pagar.me Copyright
 *
 * @link        http://pagar.me
 */

namespace PagarMe\PagarMe\Helper;

class Logger
{
    /**
     * @param mixed $data
     */
    public function logger($data){

        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/pagarme-' . date('Y-m-d') . '.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info($data);
    }
}
