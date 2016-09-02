<?php
namespace CASS\Domain\Bundles\Profile\Entity\Profile\Greetings;

final class GreetingsFM extends Greetings
{
    public function getMethod(): string
    {
        return 'fm';
    }

    public function __toString(): string
    {
        return sprintf('%s %s', $this->getFirstName(), $this->getMiddleName());
    }
}