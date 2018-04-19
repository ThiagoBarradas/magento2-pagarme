<?php


namespace PagarMe\PagarMe\Model\ResourceModel\Cards;

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
            'PagarMe\PagarMe\Model\Cards',
            'PagarMe\PagarMe\Model\ResourceModel\Cards'
        );
    }
}
