<?php

namespace PagarMe\PagarMe\Api;

interface WebhookManagementInterface
{
    /**
     * @api
     * @param mixed $data
     * @return boolean
     */
    public function save($data);
}
