<?php
/**
 * Class AbstractHandler
 *
 * @author      PagarMe Modules Team <modules@pagar.me>
 * @copyright   2018 PagarMe (http://pagar.me)
 * @license     http://pagar.me Copyright
 *
 * @link        http://pagar.me
 */

namespace PagarMe\PagarMe\Gateway\Transaction\Base\ResourceGateway\Response;


use Magento\Payment\Gateway\Data\PaymentDataObjectInterface;
use Magento\Payment\Gateway\Response\HandlerInterface;

abstract class AbstractHandler implements HandlerInterface
{
    /**
     * @param $payment
     * @param $response
     * @return mixed
     */
    abstract protected function _handle($payment, $response);

    /**
     * {@inheritdoc}
     */
    public function handle(array $handlingSubject, array $response)
    {
        if (
            ! isset($handlingSubject['payment']) ||
            ! $handlingSubject['payment'] instanceof PaymentDataObjectInterface
        ) {
            throw new \InvalidArgumentException('Payment data object should be provided');
        }

        $response = $response['response'];
        $paymentDO = $handlingSubject['payment'];
        $payment = $paymentDO->getPayment();
        /** @TODO CREATE A BUILD RESPONSE */
        $this->_handle($payment, $response);
    }
}
