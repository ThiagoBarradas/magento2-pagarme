<?php


namespace PagarMe\PagarMe\Api\Data;

interface ChargesSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{


    /**
     * Get Charges list.
     * @return \PagarMe\PagarMe\Api\Data\ChargesInterface[]
     */
    public function getItems();

    /**
     * Set content list.
     * @param \PagarMe\PagarMe\Api\Data\ChargesInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
