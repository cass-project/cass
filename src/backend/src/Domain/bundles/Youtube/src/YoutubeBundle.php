<?php

namespace Domain\Youtube;


use Application\Bundle\GenericBundle;

class YoutubeBundle extends GenericBundle
{
    public function getDir(){
        return __DIR__;
    }
}