<?php

namespace VerifyMy\SDK\Business;

use VerifyMy\SDK\Commons\Security\HMAC;
use VerifyMy\SDK\Commons\Transport\HTTP;
use VerifyMy\SDK\Business\BusinessClient;
use VerifyMy\SDK\Business\Entity\Requests\AllowedRedirectUrlsRequest;
use VerifyMy\SDK\Core\Validator\ValidationException;
use VerifyMy\SDK\Commons\Transport\InvalidStatusCodeException;


final class BusinessClientV1 implements BusinessClient
{
    const ENDPOINT_ALLOWED_REDIRECT_URLS = '/allowed-redirects';

    /**
     * @var HTTP $transport
     */
    private $transport;

    /**
     * @var HMAC $hmac
     */
    private HMAC $hmac;

    
    /**
     * @var string $baseURL
     * @var string $nucleusApiKey
     */
    private $nucleusApiKey;

    public function __construct(string $baseURL, string $nucleusApiKey, string $apiSecret)
    {
        $uri = BusinessClient::URI;
        $this->transport = new HTTP("$baseURL/$uri");
        $this->nucleusApiKey = $nucleusApiKey;
        $this->hmac = new HMAC($nucleusApiKey, $apiSecret);
    }

    /**
     * @param AllowedRedirectUrlsRequest $request
     * @return void
     * @throws InvalidStatusCodeException
     * @throws ValidationException
     */
    public function addAllowedRedirectUrls(AllowedRedirectUrlsRequest $request): void
    {
        $data = $request->toArray();
        $this->transport->put(
            self::ENDPOINT_ALLOWED_REDIRECT_URLS,
            $data["urls"],
            [
                'Authorization' => $this->hmac->sign($data["urls"]),
            ],
            [204]
        );
    }

    /**
     * @param AllowedRedirectUrlsRequest $request
     * @return void
     * @throws InvalidStatusCodeException
     * @throws ValidationException
     */
    public function removeAllowedRedirectUrls(AllowedRedirectUrlsRequest $request): void
    {
        $data = $request->toArray();
        $this->transport->deleteWithBody(
            self::ENDPOINT_ALLOWED_REDIRECT_URLS,
            $data["urls"],
            [
                'Authorization' => $this->hmac->sign($data["urls"]),
            ],
        );
    }
}
    