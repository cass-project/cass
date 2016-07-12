<?php
namespace Domain\Feed\Search\Criteria;

interface Criteria
{
    public function getCode(): string;
    public function unpack(array $criteria);
}