<?php


namespace PagarMe\PagarMe\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface ChargesRepositoryInterface
{


    /**
     * Save Charges
     * @param \PagarMe\PagarMe\Api\Data\ChargesInterface $charges
     * @return \PagarMe\PagarMe\Api\Data\ChargesInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \PagarMe\PagarMe\Api\Data\ChargesInterface $charges
    );

    /**
     * Retrieve Charges
     * @param string $chargesId
     * @return \PagarMe\PagarMe\Api\Data\ChargesInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($chargesId);

    /**
     * Retrieve Charges matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \PagarMe\PagarMe\Api\Data\ChargesSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Charges
     * @param \PagarMe\PagarMe\Api\Data\ChargesInterface $charges
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \PagarMe\PagarMe\Api\Data\ChargesInterface $charges
    );

    /**
     * Delete Charges by ID
     * @param string $chargesId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($chargesId);
}
