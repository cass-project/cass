<?php
namespace Application\Feed;

use Application\Common\Bootstrap\Bundle\GenericBundle;

class FeedBundle extends GenericBundle
{
    public function getDir() {
        return __DIR__;
    }
}