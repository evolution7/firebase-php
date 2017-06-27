<?php


namespace Kreait\Firebase\Auth;

use Kreait\Firebase\Auth\User\Email;
use Kreait\Firebase\Auth\User\Profile;

class User
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var Email
     */
    private $email;

    /**
     * @var string
     */
    private $idToken;

    /**
     * @var string
     */
    private $refreshToken;

    /**
     * @var Profile
     */
    private $profile;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setEmail(Email $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function setIdToken(string $token): self
    {
        $user = clone $this;
        $user->idToken = $token;

        return $user;
    }

    public function getIdToken(): string
    {
        return $this->idToken;
    }

    public function setRefreshToken(string $token): self
    {
        $this->refreshToken = $token;

        return $this;
    }

    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }

    public function setProfile(Profile $profile): self
    {
        $this->profile = $profile;

        return $this;
    }

    public function getProfile(): Profile
    {
        return $this->profile;
    }
}
