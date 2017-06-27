<?php


namespace Kreait\Firebase\Auth;


use Kreait\Firebase\Auth\Method\EmailAndPassword;
use Kreait\Firebase\Auth\User\Email;
use Kreait\Firebase\Auth\User\Profile;
use Kreait\Firebase\Exception\LogicException;
use Kreait\Firebase\Util\JSON;

class UserManager
{
    /**
     * @var ApiClient
     */
    private $client;

    public function __construct(ApiClient $apiClient)
    {
        $this->client = $apiClient;
    }

    public function createUser(Method $method): User
    {
        switch (true) {
            case $method instanceof EmailAndPassword:
                $response = $this->client->signUpWithEmailAndPassword($method);
                break;
            default:
                throw new LogicException(sprintf('Unsupported method "%s"', get_class($method)));
        }

        $data = JSON::decode((string) $response->getBody(), true);

        return (new User($data['localId']))
            ->setEmail(new Email($data['email']))
            ->setIdToken($data['idToken'])
            ->setRefreshToken($data['refreshToken'])
        ;
    }

    public function getUser(Method $method): User
    {
        switch (true) {
            case $method instanceof EmailAndPassword:
                $response = $this->client->getUserFromEmailAndPassword($method);
                break;
            default:
                throw new LogicException(sprintf('Unsupported method "%s"', get_class($method)));
        }

        $data = JSON::decode((string) $response->getBody(), true);

        return (new User($data['localId']))
            ->setEmail(new Email($data['email']))
            ->setIdToken($data['idToken'])
            ->setRefreshToken($data['refreshToken'])
        ;
    }

    public function loadProfile(User $user): User
    {
        $response = $this->client->getAccountInfo($user);

        $data = JSON::decode((string) $response->getBody(), true);

        $profile = new Profile($data);

        return $user->setProfile($profile);
    }

    public function deleteUser(User $user)
    {
        $this->client->deleteUser($user);
    }
}
