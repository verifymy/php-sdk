<?php

namespace VerifyMy\SDK\Commons\Security;

class HMAC {

    private $apiKey;

    private $apiSecret;

    function __construct($apiKey, $apiSecret)
    {
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
    }

    /**
     * Generate the HMAC signature based on input and API keys
     */
    public function generate($input, bool $header = false): string
    {
        if (is_array($input)) {
            $input = json_encode($input);
        }

        $hash = hash_hmac('sha256', $input, $this->apiSecret);
        return sprintf("%s%s:%s", $header ? 'hmac ': '', $this->apiKey, $hash);
    }

    /**
     * Validates that a generated HMAC
     * @param $hash
     * @param $input
     * @return bool
     */
    public function validate($hash, $input): bool
    {
        return $this->generate($input) === $this->removePrefix($hash);
    }

    private function removePrefix($header)
    {
        return preg_replace('/^hmac ?/i', '', $header);
    }

    /*
     * Sign the input with the API key and secret
     */
    public function sign($input): string
    {
        return sprintf("hmac %s", $this->generate($input));
    }
}