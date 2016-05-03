<?php
namespace Feed\Feed;

interface Criteria
{
    public static function isAvailable(array $request): bool;
    public function __construct(array $request);
}