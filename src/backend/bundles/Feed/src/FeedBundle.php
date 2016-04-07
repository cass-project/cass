<?php
namespace Feed;

use Application\Bootstrap\Bundle\GenericBundle;

class FeedBundle extends GenericBundle
{
    public function getDir()
    {
        return __DIR__;
    }
}