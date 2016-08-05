<?php
namespace Domain\Profile\Parameters;

class EditPersonalParameters
{
    /** @var string */
    private $gender;

    /** @var bool */
    private $avatar;

    /** @var string */
    private $method;

    /** @var string */
    private $firstName;

    /** @var string */
    private $lastName;

    /** @var string */
    private $middleName;

    /** @var string */
    private $nickName;

    public function __construct(
        string $method,
        bool $avatar,
        string $firstName,
        string $lastName,
        string $middleName,
        string $nickName
    )
    {
        $this->method = $method;
        $this->avatar = $avatar;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->middleName = $middleName;
        $this->nickName = $nickName;
    }

    public function specifyGender(string $gender)
    {
        $this->gender = $gender;
    }

    public function isGenderSpecified(): bool
    {
        return $this->gender !== null;
    }

    public function isAvatarRegenetateRequested(): bool
    {
        return $this->avatar;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getMiddleName(): string
    {
        return $this->middleName;
    }

    public function getNickName(): string
    {
        return $this->nickName;
    }
}