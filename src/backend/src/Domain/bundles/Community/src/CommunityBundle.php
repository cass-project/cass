<?php
namespace Domain\Community;

use Application\Bundle\GenericBundle;

final class CommunityBundle extends GenericBundle
{
    public function getDir()
    {
        return __DIR__;
    }
}