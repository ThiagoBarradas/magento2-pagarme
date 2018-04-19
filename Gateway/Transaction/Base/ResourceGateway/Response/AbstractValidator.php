<?php
/**
 * Class AbstractValidator
 *
 * @author      PagarMe Modules Team <modules@pagar.me>
 * @copyright   2018 PagarMe (http://pagar.me)
 * @license     http://pagar.me Copyright
 *
 * @link        http://pagar.me
 */

namespace PagarMe\PagarMe\Gateway\Transaction\Base\ResourceGateway\Response;


use Magento\Payment\Gateway\Validator\ResultInterfaceFactory;
use Magento\Payment\Gateway\Validator\ResultInterface;

abstract class AbstractValidator
{
    protected $resultInterfaceFactory;

    /**
     * @param ResultInterfaceFactory $resultFactory
     */
    public function __construct(
        ResultInterfaceFactory $resultFactory
    )
    {
        $this->setResultInterfaceFactory($resultFactory);
    }

    /**
     * @param array $validationSubject
     * @return ResultInterface
     */
    abstract public function validate(array $validationSubject);

    /**
     * @param bool $isValid
     * @param array $fails
     * @return ResultInterface
     */
    protected function createResult($isValid, array $fails = [])
    {
        return $this->getResultInterfaceFactory()->create(
            [
                'isValid' => (bool)$isValid,
                'failsDescription' => $fails
            ]
        );
    }

    /**
     * @return ResultInterfaceFactory
     */
    protected function getResultInterfaceFactory()
    {
        return $this->resultInterfaceFactory;
    }

    /**
     * @param ResultInterfaceFactory $resultInterfaceFactory
     * @return $this
     */
    protected function setResultInterfaceFactory(ResultInterfaceFactory $resultInterfaceFactory)
    {
        $this->resultInterfaceFactory = $resultInterfaceFactory;
        return $this;
    }
}
