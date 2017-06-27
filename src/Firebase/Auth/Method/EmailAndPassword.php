<?php


namespace Kreait\Firebase\Auth\Method;


use Kreait\Firebase\Auth\Method;

class EmailAndPassword implements Method
{
    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $password;

    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }
}
