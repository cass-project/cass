<?php
namespace CASS\Domain\Auth\Parameters;

class SignUpParameters
{
    /** @var string */
    private $email;

    /** @var string */
    private $password;

    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}