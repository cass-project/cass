<?php
namespace Domain\IM\Exception\Query\Options;

interface Option
{
    public static function getCode(): string;
    public function unpack(array $params);
}