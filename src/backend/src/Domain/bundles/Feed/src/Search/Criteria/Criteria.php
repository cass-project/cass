<?php
namespace Domain\Feed\Search\Criteria;

interface Criteria
{
    public function unpack(array $criteria);
}