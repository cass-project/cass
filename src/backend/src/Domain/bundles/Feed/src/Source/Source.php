<?php
namespace Domain\Feed\Source;

use Domain\Feed\Service\Entity;

interface Source
{
    public function getMongoDBCollection(): string;
    public function test(Entity $entity);
}