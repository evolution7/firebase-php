<?php

namespace Kreait\Firebase\Auth;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Uri;
use Kreait\Firebase\Exception\ApiException;
use Kreait\Firebase\Exception\UnableToCreateUser;
use Kreait\Firebase\Util\JSON;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

class ApiClient
{
    /**
     * @var ClientInterface
     */
    private $httpClient;

    public function __construct(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function signUpWithEmailAndPassword(string $email, string $password): ResponseInterface
    {
        try {
            return $this->httpClient->request('POST', 'signupNewUser', [
                'json' => [
                    'email' => $email,
                    'password' => $password,
                    'returnSecureToken' => true,
                ],
            ]);
        } catch (RequestException $e) {
            $message = $e->getMessage();
            if ($response = $e->getResponse()) {
                $message = JSON::decode((string)$response->getBody(), true)['error']['message'] ?? $message;
            }

            throw new UnableToCreateUser($message, $e->getCode(), $e);
        }
    }
}
