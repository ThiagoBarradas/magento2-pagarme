<?php
/**
 * @author      PagarMe Modules Team <modules@pagar.me>
 * @copyright   2018 PagarMe (http://pagar.me)
 * @license     http://pagar.me  Copyright
 *
 * @link        http://pagar.me
 *
 */
namespace PagarMe\PagarMe\Model\Source;


use Magento\Framework\Option\ArrayInterface;

class SequenceCriteria implements ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            [
                'value' => 'OnSuccess',
                'label' => __('On Success'),
            ],
            [
                'value' => 'AuthorizeFirst',
                'label' => __('Always')
            ]
        ];
    }
}
