<?php


namespace PagarMe\PagarMe\Api\Data;

interface CardsSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{


    /**
     * Get Cards list.
     * @return \PagarMe\PagarMe\Api\Data\CardsInterface[]
     */
    public function getItems();

    /**
     * Set content list.
     * @param \PagarMe\PagarMe\Api\Data\CardsInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
