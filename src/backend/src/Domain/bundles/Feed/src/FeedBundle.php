<?php
namespace Domain\Feed;

use Application\Bundle\GenericBundle;

class FeedBundle extends GenericBundle
{
    public function getDir() {
        return __DIR__;
    }
}