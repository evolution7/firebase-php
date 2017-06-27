<?php

namespace Kreait\Firebase;

use Kreait\Firebase\Auth\ApiClient;
use Kreait\Firebase\Auth\Command\CreateUser;
use Kreait\Firebase\Auth\Method;
use Kreait\Firebase\Util\JSON;

class Auth
{
    /**
     * @var ApiClient
     */
    private $client;

    public function __construct(ApiClient $client)
    {
        $this->client = $client;
    }

    /**
     * Creates a new user and returns their UID.
     *
     * @param string $email
     * @param string $password
     *
     * @return string
     */
    public function signUpWithEmailAndPassword(string $email, string $password): string
    {
        $response = $this->client->signUpWithEmailAndPassword($email, $password);

        $data = JSON::decode((string) $response->getBody(), true);

        return $data['localId'];
    }
}
