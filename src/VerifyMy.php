<?php

namespace VerifyMy\SDK;

use VerifyMy\SDK\Business\BusinessClient;

final class VerifyMy implements VerifyMyInterface
{
    /**
     * @var BusinessClient $businessClient
     */
    private $businessClient;

    public function __construct($baseURL, $nucleusAPIKey, $apiSecret)
    {
        $businessClientClassName = BusinessClient::API_VERSIONS[BusinessClient::API_VERSION_V1];
        $this->businessClient = new $businessClientClassName($baseURL, $nucleusAPIKey, $apiSecret);
    }

    public function business(): BusinessClient
    {
        return $this->businessClient;
    }
}