<?php
namespace CASS\Domain\Bundles\Profile\Entity\Profile\Greetings;

final class GreetingsLF extends Greetings
{
    public function getMethod(): string
    {
        return 'lf';
    }

    public function __toString(): string
    {
        return sprintf('%s %s', $this->getLastName(), $this->getFirstName());
    }
}