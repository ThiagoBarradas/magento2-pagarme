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

namespace PagarMe\PagarMe\Gateway\Transaction\CreditCard\ResourceGateway\Create\Response;


use Magento\Payment\Gateway\Response\HandlerInterface;
use PagarMe\PagarMe\Gateway\Transaction\Base\ResourceGateway\Response\AbstractHandler;
use PagarMe\PagarMe\Model\ChargesFactory;
use PagarMe\PagarMe\Gateway\Transaction\CreditCard\Config\Config as ConfigCreditCard;
use PagarMe\PagarMe\Helper\Logger;

class GeneralHandler extends AbstractHandler implements HandlerInterface
{
	/**
     * \PagarMe\PagarMe\Model\ChargesFactory
     */
	protected $modelCharges;

    /**
     * \PagarMe\PagarMe\Gateway\Transaction\CreditCard\Config\Config
     */
    protected $configCreditCard;

    /**
     * @var \PagarMe\PagarMe\Helper\Logger
     */
    protected $logger;

    public function __construct(
        ConfigCreditCard $configCreditCard,
    	ChargesFactory $modelCharges,
        Logger $logger
    ) {
        $this->modelCharges = $modelCharges;
        $this->configCreditCard = $configCreditCard;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    protected function _handle($payment, $response)
    {
        $this->logger->logger(json_encode($response));
        $payment->setTransactionId($response->id);

        if($this->configCreditCard->getPaymentAction() == 'authorize_capture')
        {
            $payment->setIsTransactionClosed(true);
            $payment->accept()
                ->setParentTransactionId($response->id);
        }else{
            $payment->setIsTransactionClosed(false);
        }

        foreach($response->charges as $charge)
        {
            // $payment->setAdditionalInformation('brand', $charge->lastTransaction->card->brand);
            // $payment->setAdditionalInformation('cc_last_4', $charge->lastTransaction->card->lastFourDigits);
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
