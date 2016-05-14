<?php
namespace Domain\Profile\Middleware\Parameters;

class EditPersonalParameters
{
    private $gender;
    private $greetingsType;
    private $firstName;
    private $lastName;
    private $middleName;
    private $nickName;

    /**
     * EditPersonalParameters constructor.
     * @param $greetingsType
     * @param $firstName
     * @param $lastName
     * @param $middleName
     * @param $nickName
     */
    public function __construct(
        string $greetingsType,
        string $firstName,
        string $lastName,
        string $middleName,
        string $nickName
    ) {
        $this->greetingsType = $greetingsType;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->middleName = $middleName;
        $this->nickName = $nickName;
    }

    public function specifyGender(string $gender) {
        $this->gender = $gender;
    }

    public function isGenderSpecified(): bool {
        return $this->gender !== null;
    }

    public function getGender(): string {
        return $this->gender;
    }

    public function getGreetingsType(): string
    {
        return $this->greetingsType;
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