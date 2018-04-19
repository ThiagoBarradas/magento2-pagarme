<?php
/**
 * Class GeneralHandler
 *
 * @author      PagarMe Modules Team <modules@pagar.me>
 * @copyright   2018 PagarMe (http://pagar.me)
 * @license     http://pagar.me Copyright
 *
 * @link        http://pagar.me
 */

namespace PagarMe\PagarMe\Gateway\Transaction\Billet\ResourceGateway\Create\Response;


use Magento\Payment\Gateway\Response\HandlerInterface;
use PagarMe\PagarMe\Gateway\Transaction\Base\ResourceGateway\Response\AbstractHandler;
use PagarMe\PagarMe\Model\ChargesFactory;
use PagarMe\PagarMe\Helper\Logger;

class GeneralHandler extends AbstractHandler implements HandlerInterface
{
    /**
     * \PagarMe\PagarMe\Model\ChargesFactory
     */
    protected $modelCharges;

    /**
     * @var \PagarMe\PagarMe\Helper\Logger
     */
    protected $logger;

    /**
     * @return void
     */
    public function __construct(
        ChargesFactory $modelCharges,
        Logger $logger
    ) {
        $this->modelCharges = $modelCharges;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    protected function _handle($payment, $response)
    {
        $this->logger->logger(json_encode($response));
        
        $boletoUrl = $response->charges[0]->lastTransaction->pdf;

        $payment->setAdditionalInformation('billet_url', $boletoUrl);
        $payment->setTransactionId($response->id);
        $payment->setIsTransactionClosed(false);


        foreach($response->charges as $charge)
        {
            try {
                $model = $this->modelCharges->create();
                $model->setChargeId($charge->id);
                $model->setCode($charge->code);
                $model->setOrderId($payment->getOrder()->getIncrementId());
                $model->setType($charge->paymentMethod);
                $model->setStatus($charge->status);
                $model->setAmount($charge->amount);
                $model->setPaidAmount(0);
                $model->setRefundedAmount(0);
                $model->setCreatedAt(date("Y-m-d H:i:s"));
                $model->setUpdatedAt(date("Y-m-d H:i:s"));
                $model->save();
            } catch (\Exception $e) {
                return $e->getMessage();
            }
            
            
        }

        return $this;
    }
}
