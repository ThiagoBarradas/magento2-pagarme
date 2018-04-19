<?php
/**
 * Class AbstractRequestDataProvider
 *
 * @author      PagarMe Modules Team <modules@pagar.me>
 * @copyright   2018 PagarMe (http://pagar.me)
 * @license     http://pagar.me Copyright
 *
 * @link        http://pagar.me
 */

namespace PagarMe\PagarMe\Gateway\Transaction\Base\ResourceGateway;


use Magento\Checkout\Model\Session;
use Magento\Payment\Gateway\Data\OrderAdapterInterface;
use Magento\Payment\Model\InfoInterface;
use PagarMe\PagarMe\Helper\CustomerAddressInterface;

abstract class AbstractRequestDataProvider
{
    protected $orderAdapter;
    protected $payment;

    protected $billingAddress;
    protected $shippingAddress;
    protected $quote;
    protected $session;
    protected $customerAddressHelper;

    /**
     * @param OrderAdapterInterface $orderAdapter
     * @param InfoInterface $payment
     * @param Session $session
     */
    public function __construct(
        OrderAdapterInterface $orderAdapter,
        InfoInterface $payment,
        Session $session,
        CustomerAddressInterface $customerAddressHelper
    )
    {
        $this->setOrderAdapter($orderAdapter);
        $this->setPaymentData($payment);
        $this->setSession($session);
        $this->setCustomerAddressHelper($customerAddressHelper);
    }

    /**
     * {@inheritdoc}
     */
    public function getAmountInCents()
    {
        return $this->getOrderAdapter()->getGrandTotalAmount() * 100;
    }

    /**
     * {@inheritdoc}
     */
    public function getTransactionReference()
    {
        return $this->getOrderAdapter()->getOrderIncrementId();
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        $name = sprintf(
            '%s %s %s',
            $this->getCustomer()->getFirstname(),
            $this->getCustomer()->getMiddlename(),
            $this->getCustomer()->getLastname()
        );

        return trim($name);
    }

    /**
     * {@inheritdoc}
     */
    public function getPersonType()
    {
        return \PagarMe\PagarMe\Model\Enum\PersonTypeEnum::COMPANY;
    }

    /**
     * {@inheritdoc}
     */
    public function getDocumentNumber()
    {
        return '58828172000138';
    }

    /**
     * {@inheritdoc}
     */
    public function getDocumentType()
    {
        $identity = (int) preg_replace('/[^0-9]/','', $this->getDocumentNumber());
        return (strlen($identity) === 14) ?
            \PagarMe\PagarMe\Model\Enum\DocumentTypeEnum::CNPJ :
            \PagarMe\PagarMe\Model\Enum\DocumentTypeEnum::CPF;
    }


    /**
     * {@inheritdoc}
     */
    public function getEmail()
    {
        return $this->getCustomer()->getEmail();
    }

    /**
     * {@inheritdoc}
     */
    public function getHomePhone()
    {
        return $this->getBillingAddressAttribute('telephone');
    }

    /**
     * {@inheritdoc}
     */
    public function getBillingAddressStreet()
    {
        return $this->getBillingAddressAttribute(
            $this->getCustomerAddressHelper()->getStreetAttribute()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getBillingAddressNumber()
    {
        return $this->getBillingAddressAttribute(
            $this->getCustomerAddressHelper()->getNumberAttribute()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getBillingAddressComplement()
    {
        return $this->getBillingAddressAttribute(
            $this->getCustomerAddressHelper()->getComplementAttribute()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getBillingAddressDistrict()
    {
        return $this->getBillingAddressAttribute(
            $this->getCustomerAddressHelper()->getDistrictAttribute()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getBillingAddressCity()
    {
        return $this->getBillingAddressAttribute('city');
    }

    /**
     * {@inheritdoc}
     */
    public function getBillingAddressState()
    {
        return $this->getBillingAddress()->getRegionCode();
    }

    /**
     * {@inheritdoc}
     */
    public function getBillingAddressZipCode()
    {
        return preg_replace('/[^0-9]/','', $this->getBillingAddressAttribute('postcode'));
    }

    /**
     * {@inheritdoc}
     */
    public function getBillingAddressCountry()
    {
        return \PagarMe\PagarMe\Model\Enum\CountryEnum::BRAZIL;
    }

    /**
     * {@inheritdoc}
     */
    public function getShippingAddressStreet()
    {
        return $this->getShippingAddressAttribute(
            $this->getCustomerAddressHelper()->getStreetAttribute()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getShippingAddressNumber()
    {
        return $this->getShippingAddressAttribute(
            $this->getCustomerAddressHelper()->getNumberAttribute()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getShippingAddressComplement()
    {
        return $this->getShippingAddressAttribute(
            $this->getCustomerAddressHelper()->getComplementAttribute()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getShippingAddressDistrict()
    {
        return $this->getShippingAddressAttribute(
            $this->getCustomerAddressHelper()->getDistrictAttribute()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getShippingAddressCity()
    {
        return $this->getShippingAddressAttribute('city');
    }

    /**
     * {@inheritdoc}
     */
    public function getShippingAddressState()
    {
        return $this->getShippingAddress()->getRegionCode();
    }

    /**
     * {@inheritdoc}
     */
    public function getShippingAddressZipCode()
    {
        return preg_replace('/[^0-9]/','', $this->getShippingAddressAttribute('postcode'));
    }

    /**
     * {@inheritdoc}
     */
    public function getShippingAddressCountry()
    {
        return \PagarMe\PagarMe\Model\Enum\CountryEnum::BRAZIL;
    }

    /**
     * {@inheritdoc}
     */
    public function getIpAddress()
    {
        return $this->getOrderAdapter()->getRemoteIp();
    }


    /**
     * {@inheritdoc}
     */
    public function getSessionId()
    {
        return $this->getSession()->getSessionId();
    }

    /**
     * {@inheritdoc}
     */
    public function getCartItems()
    {
        $items = [];
        /** @var \Magento\Sales\Model\Order\Item $item */
        foreach ($this->getOrderAdapter()->getItems() as $item) {
            if ($item->getProductType() !== 'simple') {
                continue;
            }

            if (!$item->isDeleted() && !$item->getParentItemId()) {
                $items[] = $item;
            }
        }

        return $items;
    }

    /**
     * @param $brand
     * @return string
     */
    protected function getBrandAdapter($brand)
    {
        $fromTo = [
            'VI' => \PagarMe\PagarMe\Model\Enum\CreditCardBrandEnum::VISA,
            'MC' => \PagarMe\PagarMe\Model\Enum\CreditCardBrandEnum::MASTERCARD,
            'AE' => \PagarMe\PagarMe\Model\Enum\CreditCardBrandEnum::AMEX,
            'DI' => \PagarMe\PagarMe\Model\Enum\CreditCardBrandEnum::DISCOVER,
            'DN' => \PagarMe\PagarMe\Model\Enum\CreditCardBrandEnum::DINERS,
        ];

        return (isset($fromTo[$brand])) ? $fromTo[$brand] : false;
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
    protected function getPaymentData()
    {
        return $this->payment;
    }

    /**
     * @param InfoInterface $payment
     * @return $this
     */
    protected function setPaymentData(InfoInterface $payment)
    {
        $this->payment = $payment;
        return $this;
    }

    /**
     * @return Session
     */
    protected function getSession()
    {
        return $this->session;
    }

    /**
     * @param Session $session
     * @return $this
     */
    protected function setSession(Session $session)
    {
        $this->session = $session;
        return $this;
    }

    /**
     * @return \Magento\Payment\Gateway\Data\AddressAdapterInterface|null
     */
    protected function getShippingAddress()
    {
        if (!$this->shippingAddress) {
            $this->shippingAddress = $this->getOrderAdapter()->getShippingAddress();
        }
        return $this->shippingAddress;
    }

    /**
     * @return \Magento\Payment\Gateway\Data\AddressAdapterInterface|null
     */
    protected function getBillingAddress()
    {
        if (!$this->billingAddress) {
            $this->billingAddress = $this->getOrderAdapter()->getBillingAddress();
        }
        return $this->billingAddress;
    }

    /**
     * @return \Magento\Quote\Model\Quote
     */
    protected function getQuote()
    {
        if (! $this->quote) {
            $this->quote = $this->getSession()->getQuote();
        }
        return $this->quote;
    }

    /**
     * @return \Magento\Quote\Model\Quote\Address
     */
    protected function getQuoteBillingAddress()
    {
        return $this->getQuote()->getBillingAddress();
    }

    /**
     * @return \Magento\Quote\Model\Quote\Address
     */
    protected function getQuoteShippingAddress()
    {
        return $this->getQuote()->getShippingAddress();
    }

    /**
     * @param $attribute
     * @return string
     */
    protected function getBillingAddressAttribute($attribute)
    {
        if (preg_match('/^street_/', $attribute)) {
            $line = (int) str_replace('street_', '', $attribute);
            return $this->getQuoteBillingAddress()->getStreetLine($line);
        }
        return $this->getQuoteBillingAddress()->getData($attribute);
    }

    /**
     * @param $attribute
     * @return string
     */
    protected function getShippingAddressAttribute($attribute)
    {
        if (preg_match('/^street_/', $attribute)) {
            $line = (int) str_replace('street_', '', $attribute);
            return $this->getQuoteShippingAddress()->getStreetLine($line);
        }
        return $this->getQuoteShippingAddress()->getData($attribute);
    }

    /**
     * @return \Magento\Customer\Api\Data\CustomerInterface|\Magento\Framework\Api\ExtensibleDataInterface
     */
    protected function getCustomer()
    {
        return $this->getQuote()->getCustomer();
    }

    /**
     * @return CustomerAddressInterface
     */
    protected function getCustomerAddressHelper()
    {
        return $this->customerAddressHelper;
    }

    /**
     * @param CustomerAddressInterface $customerAddressHelper
     * @return self
     */
    protected function setCustomerAddressHelper(CustomerAddressInterface $customerAddressHelper)
    {
        $this->customerAddressHelper = $customerAddressHelper;
        return $this;
    }
}
