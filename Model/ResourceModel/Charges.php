<?php


namespace PagarMe\PagarMe\Model\ResourceModel;

class Charges extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('pagarme_pagarme_charges', 'id');
    }
}
