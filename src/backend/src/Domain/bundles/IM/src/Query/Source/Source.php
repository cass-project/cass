<?php
namespace CASS\Domain\Bundles\IM\Query\Source;

interface Source
{
    public static function getCode(): string;
    public function getSourceId(): int;
    public function getMongoDBCollectionName(): string;
}