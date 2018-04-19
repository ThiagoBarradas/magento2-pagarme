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

namespace PagarMe\PagarMe\Gateway\Transaction\BilletCreditCard\ResourceGateway\Refund\Response;


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
        $model = $this->modelCharges->create();
        $charge = $model->getCollection()->addFieldToFilter('charge_id',array('eq' => $response->id))->getFirstItem();
        try {
            $charge->setStatus($response->status);
            $charge->setPaidAmount($response->amount);
            $charge->setUpdatedAt(date("Y-m-d H:i:s"));
            $charge->save();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        
        return $this;
    }
}
