<?php
/**
 * Class CustomerAddress
 *
 * @author      PagarMe Modules Team <modules@pagar.me>
 * @copyright   2018 PagarMe (http://pagar.me)
 * @license     http://pagar.me Copyright
 *
 * @link        http://pagar.me
 */

namespace PagarMe\PagarMe\Helper;


class CustomerAddress extends AbstractHelper implements CustomerAddressInterface
{
    /**
     * {@inheritdoc}
     */
    public function getStreetAttribute()
    {
        return $this->getConfigValue(static::PATH_STREET_ATTRIBUTE);
    }

    /**
     * {@inheritdoc}
     */
    public function getNumberAttribute()
    {
        return $this->getConfigValue(static::PATH_NUMBER_ATTRIBUTE);
    }

    /**
     * {@inheritdoc}
     */
    public function getComplementAttribute()
    {
        return $this->getConfigValue(static::PATH_COMPLEMENT_ATTRIBUTE);
    }

    /**
     * {@inheritdoc}
     */
    public function getDistrictAttribute()
    {
        return $this->getConfigValue(static::PATH_DISTRICT_ATTRIBUTE);
    }
}
