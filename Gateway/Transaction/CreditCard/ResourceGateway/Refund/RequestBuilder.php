<?php
/**
 * Class RequestBuilder
 *
 * @author      PagarMe Modules Team <modules@pagar.me>
 * @copyright   2018 PagarMe (http://pagar.me)
 * @license     http://pagar.me Copyright
 *
 * @link        http://pagar.me
 */

namespace PagarMe\PagarMe\Gateway\Transaction\CreditCard\ResourceGateway\Refund;

use Magento\Payment\Gateway\Data\OrderAdapterInterface;
use Magento\Payment\Model\InfoInterface;
use Magento\Sales\Model\Order\Item;
use PagarMe\PagarMe\Api\CartItemRequestDataProviderInterface;
use PagarMe\PagarMe\Api\CreditCardRequestDataProviderInterface;
use Magento\Payment\Gateway\Data\PaymentDataObjectInterface;
use Magento\Payment\Gateway\Request\BuilderInterface;
use MundiAPILib\Models\CreateOrderRequest as Request;
use PagarMe\PagarMe\Api\CreditCardRequestDataProviderInterfaceFactory;
use PagarMe\PagarMe\Api\CartItemRequestDataProviderInterfaceFactory;
use Magento\Checkout\Model\Cart;
use PagarMe\PagarMe\Gateway\Transaction\Base\Config\Config;
use PagarMe\PagarMe\Gateway\Transaction\CreditCard\Config\Config as ConfigCreditCard;
use PagarMe\PagarMe\Model\ChargesFactory;
use PagarMe\PagarMe\Helper\Logger;

class RequestBuilder implements BuilderInterface
{
    protected $request;
    /** @var  CreditCardTransaction */
    protected $creditCardTransaction;
    protected $requestDataProviderFactory;
    protected $cartItemRequestDataProviderFactory;
    protected $orderAdapter;
    protected $paymentData;
    protected $cart;
    protected $config;
    protected $configCreditCard;

    /**
     * @var \PagarMe\PagarMe\Helper\Logger
     */
    protected $logger;

    /**
     * \PagarMe\PagarMe\Model\ChargesFactory
     */
    protected $modelCharges;

    /**
     * @param Request $request
     * @param CreditCardTransaction $creditCardTransaction
     * @param CreditCardRequestDataProviderInterfaceFactory $requestDataProviderFactory
     * @param CartItemRequestDataProviderInterfaceFactory $cartItemRequestDataProviderFactory
     */
    public function __construct(
        Request $request,
        CreditCardRequestDataProviderInterfaceFactory $requestDataProviderFactory,
        CartItemRequestDataProviderInterfaceFactory $cartItemRequestDataProviderFactory,
        Cart $cart,
        Config $config,
        ConfigCreditCard $configCreditCard,
        ChargesFactory $modelCharges,
        Logger $logger
    )
    {
        $this->setRequest($request);
        $this->setRequestDataProviderFactory($requestDataProviderFactory);
        $this->setCartItemRequestProviderFactory($cartItemRequestDataProviderFactory);
        $this->setCart($cart);
        $this->setConfig($config);
        $this->setConfigCreditCard($configCreditCard);
        $this->setModelCharges($modelCharges);
        $this->setLogger($logger);
    }

    /**
     * {@inheritdoc}
     */
    public function build(array $buildSubject)
    {
        if (!isset($buildSubject['payment']) || !$buildSubject['payment'] instanceof PaymentDataObjectInterface) {
            throw new \InvalidArgumentException('Payment data object should be provided');
        }

        /** @var PaymentDataObjectInterface $paymentDataObject */
        $paymentDataObject = $buildSubject['payment'];

        $this->setOrderAdapter($paymentDataObject->getOrder());
        $this->setPaymentData($paymentDataObject->getPayment());

        $this->createRequestDataProvider();

        return $this->createRefundChargeRequest();
    }

    /**
     * @param Request $request
     * @return $this
     */
    protected function setRequest(Request $request)
    {
        $this->request = $request;
        return $this;
    }

    /**
     * @return Request
     */
    protected function getRequest()
    {
        return $this->request;
    }

    /**
     * @return CreditCardRequestDataProviderInterface
     */
    protected function createRequestDataProvider()
    {
        return $this->getRequestDataProviderFactory()->create([
            'orderAdapter' => $this->getOrderAdapter(),
            'payment' => $this->getPaymentData()
        ]);
    }

    /**
     * @param Item $item
     * @return CartItemRequestDataProviderInterface
     */
    protected function createCartItemRequestDataProvider(Item $item)
    {
        return $this->getCartItemRequestProviderFactory()->create([
            'item' => $item
        ]);
    }

    /**
     * @return CreditCardTransaction
     */
    protected function getCreditCardTransaction()
    {
        return $this->creditCardTransaction;
    }

    /**
     * @param CreditCardTransaction $creditCardTransaction
     * @return RequestBuilder
     */
    protected function setCreditCardTransaction(CreditCardTransaction $creditCardTransaction)
    {
        $this->creditCardTransaction = $creditCardTransaction;
        return $this;
    }

    /**
     * @return RequestDataProviderFactory
     */
    protected function getRequestDataProviderFactory()
    {
        return $this->requestDataProviderFactory;
    }

    /**
     * @param CreditCardRequestDataProviderInterfaceFactory $requestDataProviderFactory
     * @return RequestBuilder
     */
    protected function setRequestDataProviderFactory(CreditCardRequestDataProviderInterfaceFactory $requestDataProviderFactory)
    {
        $this->requestDataProviderFactory = $requestDataProviderFactory;
        return $this;
    }

    /**
     * @return CartItemRequestDataProviderInterfaceFactory
     */
    protected function getCartItemRequestProviderFactory()
    {
        return $this->cartItemRequestDataProviderFactory;
    }

    /**
     * @param CartItemRequestDataProviderInterfaceFactory $cartItemRequestDataProviderFactory
     * @return self
     */
    protected function setCartItemRequestProviderFactory(CartItemRequestDataProviderInterfaceFactory $cartItemRequestDataProviderFactory)
    {
        $this->cartItemRequestDataProviderFactory = $cartItemRequestDataProviderFactory;
        return $this;
    }


    /**
     * @return OrderAdapterInterface
     */
    protected function getOrderAdapter()
    {
        return $this->orderAdapter;
    }

    /**
     * @param OrderAdapterInterface $orderAdapter
     * @return $this
     */
    protected function setOrderAdapter(OrderAdapterInterface $orderAdapter)
    {
        $this->orderAdapter = $orderAdapter;
        return $this;
    }

    /**
     * @return InfoInterface
     */
    public function getPaymentData()
    {
        return $this->paymentData;
    }

    /**
     * @param InfoInterface $paymentData
     * @return $this
     */
    protected function setPaymentData(InfoInterface $paymentData)
    {
        $this->paymentData = $paymentData;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * @param $cart
     */
    public function setCart($cart)
    {
        $this->cart = $cart;
    }

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @return mixed
     */
    public function setConfig($config)
    {
        $this->config = $config;
        
        return $this;
    }

    /**
     * @return mixed
     */
    public function getConfigCreditCard()
    {
        return $this->configCreditCard;
    }

    /**
     * @return mixed
     */
    public function setConfigCreditCard($configCreditCard)
    {
        $this->configCreditCard = $configCreditCard;

        return $this;
    }

    /**
     * @return \MundiAPILib\MundiAPIClient
     */
    public function getApi()
    {
        return new \MundiAPILib\MundiAPIClient($this->getConfig()->getSecretKey(), '');
    }

    /**
     * @return \MundiAPILib\Models\CreateOrderRequest
     */
    public function getRefundRequest()
    {
        return new \MundiAPILib\Models\CreateCancelChargeRequest();
    }

    /**
     * @return array|mixed
     */
    protected function createRefundChargeRequest()
    {
        $refund = $this->getRefundRequest();
        $order = $this->getPaymentData()->getOrder();
        $incrementId = $order->getIncrementId();
        $totalRefundInCents = $order->getBaseTotalRefunded() * 100;

        $model = $this->getModelCharges();
        $collection = $model->getCollection()->addFieldToFilter('order_id',array('eq' => $incrementId));

        if(count($collection) == 1){
            $charge = $collection->getFirstItem();
            try {
                $refund->amount = $totalRefundInCents;
                $refund->code = $charge->getCode();
                $this->getLogger()->logger($refund->jsonSerialize());
                $response = $this->getApi()->getCharges()->cancelCharge($charge->getChargeId(), $refund);
    
            } catch (\MundiAPILib\Exceptions\ErrorException $error) {
                $this->getLogger()->logger($error);
                throw new \InvalidArgumentException($error->message);
            } catch (\Exception $ex) {
                $this->getLogger()->logger($ex);
                throw new \InvalidArgumentException($ex->getMessage());
            }
            $this->getLogger()->logger($response);

            return $response;
        }else{
            $responseArray = [];
            foreach ($collection as $charge) {
                try {
                    $refund->amount = $charge->getAmount();
                    $refund->code = $charge->getCode();
                    $this->getLogger()->logger($refund->jsonSerialize());
                    $responseArray[] = $this->getApi()->getCharges()->cancelCharge($charge->getChargeId(), $refund);
                } catch (\MundiAPILib\Exceptions\ErrorException $error) {
                    $this->getLogger()->logger($error);
                    throw new \InvalidArgumentException($error->message);
                } catch (\Exception $ex) {
                    $this->getLogger()->logger($ex);
                    throw new \InvalidArgumentException($ex->getMessage());
                }
            }
        }
        $this->getLogger()->logger($responseArray);

        return $responseArray;
    }


    /**
     * @return mixed
     */
    public function getCartItemRequestDataProviderFactory()
    {
        return $this->cartItemRequestDataProviderFactory;
    }

    /**
     * @param mixed $cartItemRequestDataProviderFactory
     *
     * @return self
     */
    public function setCartItemRequestDataProviderFactory($cartItemRequestDataProviderFactory)
    {
        $this->cartItemRequestDataProviderFactory = $cartItemRequestDataProviderFactory;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getModelCharges()
    {
        return $this->modelCharges->create();
    }

    /**
     * @param mixed $modelCharges
     *
     * @return self
     */
    public function setModelCharges($modelCharges)
    {
        $this->modelCharges = $modelCharges;

        return $this;
    }

    /**
     * @return \PagarMe\PagarMe\Helper\Logger
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * @param \PagarMe\PagarMe\Helper\Logger $logger
     *
     * @return self
     */
    public function setLogger(\PagarMe\PagarMe\Helper\Logger $logger)
    {
        $this->logger = $logger;

        return $this;
    }
}
