<?php
namespace CASS\Domain\Feed;

use CASS\Application\Bundle\GenericBundle;

final class FeedBundle extends GenericBundle
{
    public function getDir()
    {
        return __DIR__;
    }
}