<?php
namespace Domain\IM\Query\Source;

interface Source
{
    public static function getCode(): string;
    public function getSourceId(): integer;
    public function getMongoDBCollectionName(): string;
}