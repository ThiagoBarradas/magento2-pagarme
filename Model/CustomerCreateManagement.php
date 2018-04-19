<?php
/**
 * Class InstallmentsByBrandManagements
 *
 * @author      PagarMe Modules Team <modules@pagar.me>
 * @copyright   2018 PagarMe (http://pagar.me)
 * @license     http://pagar.me Copyright
 *
 * @link        http://pagar.me
 */

namespace PagarMe\PagarMe\Model;

use PagarMe\PagarMe\Api\CustomerCreateManagementInterface;
use Magento\Customer\Model\Session;
use Magento\Customer\Model\Customer;
use PagarMe\PagarMe\Gateway\Transaction\Base\Config\Config;
use Magento\Customer\Api\CustomerRepositoryInterface;
use PagarMe\PagarMe\Helper\ModuleHelper;
use PagarMe\PagarMe\Helper\Logger;

class CustomerCreateManagement implements CustomerCreateManagementInterface
{
    const MODULE_NAME = 'PagarMe_PagarMe';
    const NAME_METADATA = 'Magento 2';

    private $session;
    private $customerModel;
    private $config;
    private $customerRepository;
    private $moduleHelper;

    /**
     * @param Session $session
     */
    public function __construct(
        Session $session,
        Customer $customerModel,
        Config $config,
        CustomerRepositoryInterface $customerRepository,
        ModuleHelper $moduleHelper,
        Logger $logger
    )
    {
        $this->setSession($session);
        $this->setCustomerModel($customerModel);
        $this->setConfig($config);
        $this->setModuleHelper($moduleHelper);
        $this->setLogger($logger);
        $this->customerRepository = $customerRepository;
    }

    public function createCustomer($customerJson, $websiteId)
    {
        if (!$websiteId) {
            $websiteId = 1;
        }

        $session = $this->getSession();
        $customerModel = $this->getCustomerModel();
        $customerModel->setWebsiteId($websiteId); 
        $customer = $customerModel->loadByEmail($customerJson['email']);
        $customerDataModel = $customer->getDataModel();

        if ($customerDataModel->getCustomAttribute('customer_id_pagarme')) {

            $customerIdPagarMe = $customerDataModel->getCustomAttribute('customer_id_pagarme')->getValue();

            $this->getLogger()->logger('id de retorno do customer' . $customerIdPagarMe);
            return [
                [
                    'customer_id_pagarme' => $customerIdPagarMe
                ]
            ];
        }

        $customerRequest = $this->createRequest($customerJson, $customer->getId());
        $this->getLogger()->logger($customerRequest->jsonSerialize());
        $result = $this->createSdk()->getCustomers()->createCustomer($customerRequest);

        $this->getLogger()->logger($result->jsonSerialize());
        
        $customerDataModel->setCustomAttribute('customer_id_pagarme', $result->id);
        $customer = $this->customerRepository->save($customerDataModel);

        return [
            [
                'customer_id_pagarme' => $result->id
            ]
        ];  
    }

    public function createRequest($customerJson, $idMagento)
    {
        $customerRequest = $this->createCustomerRequest();

        $customerRequest->name     = $customerJson['name'];
        $customerRequest->email    = $customerJson['email'];
        $customerRequest->document = $customerJson['document'];
        $customerRequest->type     = $customerJson['type'];
        $customerRequest->address  = $customerJson['address'];
        $customerRequest->metadata = $customerJson['metadata'];
        $customerRequest->phones   = $customerJson['phones'];
        $customerRequest->code     = $idMagento;
        $customerRequest->gender   = $customerJson['gender'];
        $customerRequest->metadata = [
            'module_name' => self::NAME_METADATA,
            'module_version' => $this->getModuleHelper()->getVersion(self::MODULE_NAME),
        ];

        return $customerRequest;
    }

    public function createSdk()
    {
        return new \MundiAPILib\MundiAPIClient($this->getConfig()->getSecretKey(), '');
    }

    public function createCustomerRequest()
    {
        return new \MundiAPILib\Models\CreateCustomerRequest();
    }

    /**
     * @return mixed
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @param mixed $session
     *
     * @return self
     */
    public function setSession($session)
    {
        $this->session = $session;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCustomerModel()
    {
        return $this->customerModel;
    }

    /**
     * @param mixed $customerModel
     *
     * @return self
     */
    public function setCustomerModel($customerModel)
    {
        $this->customerModel = $customerModel;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param mixed $config
     *
     * @return self
     */
    public function setConfig($config)
    {
        $this->config = $config;

        return $this;
    }

    public function getModuleHelper()
    {
        return $this->moduleHelper;
    }

    public function setModuleHelper($moduleHelper)
    {
        $this->moduleHelper = $moduleHelper;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * @param mixed $logger
     *
     * @return self
     */
    public function setLogger($logger)
    {
        $this->logger = $logger;

        return $this;
    }
}