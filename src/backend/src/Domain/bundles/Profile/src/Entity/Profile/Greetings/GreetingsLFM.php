<?php
namespace CASS\Domain\Bundles\Profile\Entity\Profile\Greetings;

final class GreetingsLFM extends Greetings
{
    public function getMethod(): string
    {
        return 'lfm';
    }

    public function __toString(): string
    {
        return sprintf('%s %s %s', $this->getLastName(), $this->getLastName(), $this->getMiddleName());
    }
}