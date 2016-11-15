<?php

namespace ZEA2\Platform\Markers\LikeEntity;

interface LikeableEntity
{
    public function getLikes(): int;
    public function getDislikes(): int;
    public function increaseLikes();
    public function increaseDislikes();
    public function decreaseLikes();
    public function decreaseDislikes();
}