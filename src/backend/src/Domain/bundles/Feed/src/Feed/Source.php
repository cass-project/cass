<?php
namespace Domain\Feed\Feed;

interface Source
{
    public function createQuery(CriteriaRequest $criteriaRequest): Query;
}