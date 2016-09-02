<?php
namespace CASS\Domain\Bundles\Post\Entity;

use CASS\Util\Entity\IdEntity\IdEntity;
use CASS\Util\Entity\IdEntity\IdTrait;
use CASS\Util\JSONSerializable;

/**
 * @Entity(repositoryClass="CASS\Domain\Bundles\Post\Repository\PostThemeEQRepository")
 * @Table(name="post_theme_ids")
 */
class PostThemeEQ implements IdEntity, JSONSerializable
{
    use IdTrait;

    /**
     * @Column(type="integer", name="post_id")
     * @var int
     */
    private $postId;

    /**
     * @Column(type="integer", name="theme_id")
     * @var int
     */
    private $themeId;

    public function __construct(int $postId, int $themeId)
    {
        $this->postId = $postId;
        $this->themeId = $themeId;
    }

    public function toJSON(): array
    {
        return [
            'id' => $this->getId(),
            'post_id' => $this->getPostId(),
            'theme_id' => $this->getThemeId(),
        ];
    }

    public function getPostId(): int
    {
        return $this->postId;
    }

    public function getThemeId(): int
    {
        return $this->themeId;
    }
}