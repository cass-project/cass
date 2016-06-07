<?php
namespace Application\Frontline;

interface FrontlineScript
{
    const TAG_GLOBAL = 'global';
    const TAG_IS_AUTHENTICATED = 'is-authenticated';

    public function tags(): array;
    public function __invoke(): array;
}