<?php
namespace CASS\Domain\Bundles\Profile\Entity\Profile\Greetings;

final class GreetingsAnonymous extends Greetings
{
    public function getMethod(): string
    {
        return 'anonymous';
    }

    public function __toString(): string
    {
        return 'Anonymous';
    }
}