<?php
namespace Domain\Profile\Entity\Profile\Greetings;

use CASS\Util\JSONSerializable;

abstract class Greetings implements JSONSerializable, \Serializable
{
    /** @var string */
    private $firstName = '';

    /** @var string */
    private $lastName = '';

    /** @var string */
    private $middleName = '';

    /** @var string */
    private $nickName = '';

    public static function createFromMethod(string $method, array $names = []): Greetings
    {
        switch (strtolower($method)) {
            default:
                throw new \OutOfBoundsException(sprintf('Unknown method `%s`', $method));

            case 'anonymous': return new GreetingsFL($names);
            case 'fl': return new GreetingsFL($names);
            case 'fm': return new GreetingsFM($names);
            case 'lf': return new GreetingsLF($names);
            case 'lfm': return new GreetingsLFM($names);
            case 'n': return new GreetingsN($names);
        }
    }

    public function __construct(array $names = [])
    {
        $this->importNames($names);
    }

    public function serialize()
    {
        return json_encode($this->toJSON());
    }

    public function unserialize($serialized)
    {
        $this->importNames(json_decode($serialized, true));
    }

    private function importNames(array $names)
    {
        $names = array_merge(/* defaults */
            [
                'first_name' => '',
                'last_lame' => '',
                'middle_name' => '',
                'nick_name' => ''
            ], $names);

        foreach ($names as $field => $name) {
            $field = str_replace('_n', 'N', $field);
            $name = trim($name);

            $this->$field = (string) $name;
        }
    }

    abstract public function getMethod(): string;

    abstract public function __toString(): string;

    public function toJSON(): array
    {
        return [
            'method' => $this->getMethod(),
            'greetings' => $this->__toString(),
            'first_name' => $this->getFirstName(),
            'last_name' => $this->getLastName(),
            'middle_name' => $this->getMiddleName(),
            'nick_name' => $this->getNickName()
        ];
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function isFirstNameSpecified(): bool
    {
        return strlen($this->firstName) > 0;
    }

    public function getMiddleName(): string
    {
        return $this->middleName;
    }

    public function getNickName(): string
    {
        return $this->nickName;
    }

    public function isLastNameSpecified(): bool
    {
        return strlen($this->lastName) > 0;
    }

    public function isMiddleNameSpecified(): bool
    {
        return strlen($this->middleName) > 0;
    }

    public function isNickNameSpecified(): bool
    {
        return strlen($this->nickName) > 0;
    }
}