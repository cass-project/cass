<?php
namespace Domain\IM\Parameters\Messages\Criteria;

interface Criteria
{
    public static function getCode(): string;
    public function unpack(array $params);
}