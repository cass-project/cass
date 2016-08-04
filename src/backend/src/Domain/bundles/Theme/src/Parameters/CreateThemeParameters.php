<?php
namespace Domain\Theme\Parameters;

use Domain\Theme\Entity\Theme;

final class CreateThemeParameters
{
    /** @var string */
    private $title;

    /** @var string */
    private $description;

    /** @var string */
    private $preview;

    /** @var int|null */
    private $parentId = null;

    /** @var int|null */
    private $forceId = null;

    /** @var string|null */
    private $specifyURL = null;

    public function __construct(
        string $title,
        string $description,
        string $preview = Theme::DEFAULT_PREVIEW,
        int $parentId = null,
        int $forceId = null,
        string $specifyURL = null
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->preview = $preview;
        $this->parentId = $parentId;
        $this->forceId = $forceId;
        $this->specifyURL = $specifyURL;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPreview(): string
    {
        return $this->preview;
    }

    public function hasParent(): bool
    {
        return $this->parentId !== null;
    }

    public function getParentId(): int
    {
        return $this->parentId;
    }

    public function hasForcedId(): bool
    {
        return $this->forceId !== null;
    }

    public function getForceId(): int
    {
        return $this->forceId;
    }

    public function hasSpecifiedURL(): bool
    {
        return $this->specifyURL !== null;
    }

    public function getSpecifiedURL(): int
    {
        return $this->specifyURL;
    }
}