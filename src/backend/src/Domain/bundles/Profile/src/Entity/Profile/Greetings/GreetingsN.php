<?php
namespace CASS\Domain\Profile\Entity\Profile\Greetings;

final class GreetingsN extends Greetings
{
    public function getMethod(): string
    {
        return 'n';
    }

    public function __toString(): string
    {
        return $this->getNickName();
    }
}