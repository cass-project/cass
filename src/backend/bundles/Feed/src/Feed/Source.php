<?php
namespace Feed\Feed;

interface Source
{
    public function createQuery(CriteriaRequest $criteriaRequest): Query;
}