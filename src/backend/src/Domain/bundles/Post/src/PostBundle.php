<?php
namespace Domain\Post;

use Application\Bundle\GenericBundle;

class PostBundle extends GenericBundle
{
    public function getDir()
    {
        return __DIR__;
    }
}