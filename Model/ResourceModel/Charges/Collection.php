<?php


namespace PagarMe\PagarMe\Model\ResourceModel\Charges;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            'PagarMe\PagarMe\Model\Charges',
            'PagarMe\PagarMe\Model\ResourceModel\Charges'
        );
    }
}
