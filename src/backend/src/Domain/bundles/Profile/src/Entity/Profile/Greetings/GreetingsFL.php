<?php
namespace CASS\Domain\Profile\Entity\Profile\Greetings;

final class GreetingsFL extends Greetings
{
    public function getMethod(): string
    {
        return 'fl';
    }

    public function __toString(): string
    {
        return sprintf("%s %s", $this->getFirstName(), $this->getLastName());
    }
}