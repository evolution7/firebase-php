<?php

namespace Kreait\Firebase\Auth;

use Fig\Http\Message\RequestMethodInterface as RequestMethod;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use Kreait\Firebase\Auth\Method\EmailAndPassword;
use Kreait\Firebase\Exception\ApiException;
use Kreait\Firebase\Exception\UnableToCreateUser;
use Kreait\Firebase\Util\JSON;
use Psr\Http\Message\ResponseInterface;

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

    public function signUpWithEmailAndPassword(EmailAndPassword $method): ResponseInterface
    {
        try {
            return $this->httpClient->request(RequestMethod::METHOD_POST, 'signupNewUser', [
                'json' => [
                    'email' => $method->email,
                    'password' => $method->password,
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

    public function getUserFromEmailAndPassword(EmailAndPassword $method): ResponseInterface
    {
        try {
            return $this->httpClient->request(RequestMethod::METHOD_POST, 'verifyPassword', [
                'json' => [
                    'email' => $method->email,
                    'password' => $method->password,
                    'returnSecureToken' => true,
                ]
            ]);
        } catch (RequestException $e) {
            $message = $e->getMessage();
            if ($response = $e->getResponse()) {
                $message = JSON::decode((string)$response->getBody(), true)['error']['message'] ?? $message;
            }

            throw new ApiException($message, $e->getCode(), $e);
        }
    }

    public function getAccountInfo(User $user): ResponseInterface
    {
        try {
            return $this->httpClient->request(RequestMethod::METHOD_POST, 'getAccountInfo', [
                'json' => [
                    'idToken' => $user->getIdToken()
                ]
            ]);
        } catch (RequestException $e) {
            $message = $e->getMessage();
            if ($response = $e->getResponse()) {
                $message = JSON::decode((string)$response->getBody(), true)['error']['message'] ?? $message;
            }

            throw new ApiException($message, $e->getCode(), $e);
        }
    }

    public function deleteUser(User $user): ResponseInterface
    {
        try {
            return $this->httpClient->request(RequestMethod::METHOD_POST, 'deleteAccount', [
                'json' => [
                    'idToken' => $user->getIdToken()
                ]
            ]);
        } catch (RequestException $e) {
            $message = $e->getMessage();
            if ($response = $e->getResponse()) {
                $message = JSON::decode((string)$response->getBody(), true)['error']['message'] ?? $message;
            }

            throw new ApiException($message, $e->getCode(), $e);
        }
    }
}
