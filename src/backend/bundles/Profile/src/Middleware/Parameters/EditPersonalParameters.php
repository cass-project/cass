<?php
namespace Profile\Middleware\Parameters;

use Profile\Entity\ProfileGreetings;

class EditPersonalParameters
{
    private $greetingsType;
    private $firstName;
    private $lastName;
    private $middleName;
    private $nickName;

    public function __construct(\stdClass $data)
    {
        $this->greetingsType = $data->greetings_type;
        $this->firstName = (string) $data->first_name;
        $this->lastName = (string) $data->last_name;
        $this->middleName = (string) $data->middle_name;
        $this->nickName = (string) $data->nickname;

        if(!in_array($this->greetingsType, ProfileGreetings::AVAILABLE_GREETINGS)) {
            throw new \Exception('Invalid greetings');
        }
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