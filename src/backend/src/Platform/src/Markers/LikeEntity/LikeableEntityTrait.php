<?php

namespace ZEA2\Platform\Markers\LikeEntity;

trait LikeableEntityTrait
{
    /**
     * @Column(type="integer", name="likes")
     * @var int
     */
    protected $likes = 0;

    /**
     * @Column(type="integer", name="dislikes")
     * @var int
     */
    protected $dislikes = 0;

    public function getLikes(): int
    {
        return $this->likes;
    }

    public function getDislikes(): int
    {
        return $this->dislikes;
    }

    public function increaseLikes()
    {
        $this->likes++;

        return $this;
    }

    public function increaseDislikes()
    {
        $this->dislikes++;

        return $this;
    }

    public function decreaseLikes()
    {
        $this->likes--;

        return $this;
    }

    public function decreaseDislikes()
    {
        $this->dislikes--;

        return $this;
    }

}