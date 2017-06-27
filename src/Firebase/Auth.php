<?php

namespace Kreait\Firebase;

use Kreait\Firebase\Auth\ApiClient;
use Kreait\Firebase\Auth\Command\CreateUser;
use Kreait\Firebase\Auth\Method;
use Kreait\Firebase\Auth\UserManager;
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

    public function getUserManager(): UserManager
    {
        static $manager;

        return $manager ?? $manager = new UserManager($this->client);
    }

    /**
     * Creates a new user and returns their UID.
     *
     * @deprecated
     *
     * @param string $email
     * @param string $password
     *
     * @return string
     */
    public function signUpWithEmailAndPassword(string $email, string $password): string
    {
        return $this->getUserManager()->createUser(new Method\EmailAndPassword($email, $password))->getId();
    }
}
