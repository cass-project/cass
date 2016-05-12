<?php
namespace Domain\Auth\Parameters;

class SignUpParameters
{
    /** @var string */
    private $email;

    /** @var string */
    private $password;

    /** @var string */
    private $repeat;

    public function __construct($email, $password, $repeat)
    {
        $this->email = $email;
        $this->password = $password;
        $this->repeat = $repeat;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRepeat(): string
    {
        return $this->repeat;
    }
}