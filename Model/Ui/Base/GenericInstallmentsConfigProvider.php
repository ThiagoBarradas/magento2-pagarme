<?php
/**
 * Class GenericInstallmentConfigProvider
 *
 * @author      PagarMe Modules Team <modules@pagar.me>
 * @copyright   2018 PagarMe (http://pagar.me)
 * @license     http://pagar.me Copyright
 *
 * @link        http://pagar.me
 */

namespace PagarMe\PagarMe\Model\Ui\Base;


use PagarMe\PagarMe\Model\Installments\Config\ConfigInterface;
use PagarMe\PagarMe\Gateway\Transaction\Base\Config\ConfigInterface as BaseConfig;
use Magento\Checkout\Model\ConfigProviderInterface;

abstract class GenericInstallmentsConfigProvider implements ConfigProviderInterface
{
    const CODE = null;

    protected $installments = [];
    protected $installmentsBuilder;
    protected $installmentsConfig;
    protected $config;
    protected $_assetRepo;
    protected $baseConfig;

    public function __construct(
        \Magento\Framework\View\Asset\Repository $assetRepo,
        ConfigInterface $config,
        BaseConfig $baseConfig
    )
    {
        $this->_assetRepo = $assetRepo;
        $this->baseConfig = $baseConfig;
        $this->setConfig($config);
    }

    public function getConfig()
    {
        $config = [
            'payment' => [
                'ccform' => [
                    'installments' => [
                        'active' => [$this::CODE => $this->_getConfig()->isActive()],
                        'value' => 0,
                    ],
                    'pk_token' => $this->baseConfig->getPublicKey(),
                    'icons' => [
                        'Visa' => [
                            'height' => 30,
                            'width' => 46,
                            'url' => $this->_assetRepo->getUrl("PagarMe_PagarMe::images/cc/Visa.png")
                        ],
                        'Elo' => [
                            'height' => 30,
                            'width' => 46,
                            'url' => $this->_assetRepo->getUrl("PagarMe_PagarMe::images/cc/Elo.png")
                        ],
                        'Discover' => [
                            'height' => 30,
                            'width' => 46,
                            'url' => $this->_assetRepo->getUrl("PagarMe_PagarMe::images/cc/Discover.png")
                        ],
                        'Diners' => [
                            'height' => 30,
                            'width' => 46,
                            'url' => $this->_assetRepo->getUrl("PagarMe_PagarMe::images/cc/Diners.png")
                        ],
                        'Credz' => [
                            'height' => 30,
                            'width' => 46,
                            'url' => $this->_assetRepo->getUrl("PagarMe_PagarMe::images/cc/Credz.png")
                        ],
                        'Hipercard' => [
                            'height' => 30,
                            'width' => 46,
                            'url' => $this->_assetRepo->getUrl("PagarMe_PagarMe::images/cc/Hipercard.png")
                        ],
                        'Mastercard' => [
                            'height' => 30,
                            'width' => 46,
                            'url' => $this->_assetRepo->getUrl("PagarMe_PagarMe::images/cc/Mastercard.png")
                        ],
                        'SodexoAlimentacao' => [
                            'height' => 30,
                            'width' => 46,
                            'url' => $this->_assetRepo->getUrl("PagarMe_PagarMe::images/cc/SodexoAlimentacao.png")
                        ],
                        'SodexoCombustivel' => [
                            'height' => 30,
                            'width' => 46,
                            'url' => $this->_assetRepo->getUrl("PagarMe_PagarMe::images/cc/SodexoCombustivel.png")
                        ],
                        'SodexoCultura' => [
                            'height' => 30,
                            'width' => 46,
                            'url' => $this->_assetRepo->getUrl("PagarMe_PagarMe::images/cc/SodexoCultura.png")
                        ],
                        'SodexoGift' => [
                            'height' => 30,
                            'width' => 46,
                            'url' => $this->_assetRepo->getUrl("PagarMe_PagarMe::images/cc/SodexoGift.png")
                        ],
                        'SodexoPremium' => [
                            'height' => 30,
                            'width' => 46,
                            'url' => $this->_assetRepo->getUrl("PagarMe_PagarMe::images/cc/SodexoPremium.png")
                        ],
                        'SodexoRefeicao' => [
                            'height' => 30,
                            'width' => 46,
                            'url' => $this->_assetRepo->getUrl("PagarMe_PagarMe::images/cc/SodexoRefeicao.png")
                        ],
                        'Cabal' => [
                            'height' => 30,
                            'width' => 46,
                            'url' => $this->_assetRepo->getUrl("PagarMe_PagarMe::images/cc/Cabal.png")
                        ],
                        'Aura' => [
                            'height' => 30,
                            'width' => 46,
                            'url' => $this->_assetRepo->getUrl("PagarMe_PagarMe::images/cc/Aura.png")
                        ],
                        'Amex' => [
                            'height' => 30,
                            'width' => 46,
                            'url' => $this->_assetRepo->getUrl("PagarMe_PagarMe::images/cc/Amex.png")
                        ],
                        'Alelo' => [
                            'height' => 30,
                            'width' => 46,
                            'url' => $this->_assetRepo->getUrl("PagarMe_PagarMe::images/cc/Alelo.png")
                        ],
                        'VR' => [
                            'height' => 30,
                            'width' => 46,
                            'url' => $this->_assetRepo->getUrl("PagarMe_PagarMe::images/cc/VR.png")
                        ],
                        'Banese' => [
                            'height' => 30,
                            'width' => 46,
                            'url' => $this->_assetRepo->getUrl("PagarMe_PagarMe::images/cc/Banese.png")
                        ],
                    ],
                ]
            ]
        ];
        return $config;
    }


    /**
     * @param ConfigInterface $config
     * @return $this
     */
    protected function setConfig(ConfigInterface $config)
    {
        $this->config = $config;
        return $this;
    }

    /**
     * @return ConfigInterface
     */
    protected function _getConfig()
    {
        return $this->config;
    }
}
