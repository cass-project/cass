<?php
namespace Domain\Index\Source;

interface Source
{
    public function getMongoDBCollection(): string;
}