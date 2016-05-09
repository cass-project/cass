<?php
namespace Application\Frontline;

interface FrontlineScript
{
    public function __invoke(): array;
}