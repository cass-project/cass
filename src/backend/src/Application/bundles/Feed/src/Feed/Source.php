<?php
namespace Application\Feed\Feed;

interface Source
{
    public function createQuery(CriteriaRequest $criteriaRequest): Query;
}