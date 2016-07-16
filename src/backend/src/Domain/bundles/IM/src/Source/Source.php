<?php
namespace Domain\IM\Source;

interface Source
{
    public static function getCode(): string;
    public function getMongoDBCollectionName(): string;
}