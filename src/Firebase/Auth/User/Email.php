<?php

namespace Kreait\Firebase\Auth\User;

class Email
{
    /**
     * @var string
     */
    private $value;
    /**
     * @var bool
     */
    private $isVerified;

    public function __construct(string $value, bool $isVerified = false)
    {
        $this->value = $value;
        $this->isVerified = $isVerified;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function __toString()
    {
        return $this->value;
    }
}
