<?php
namespace CASS\Domain\Bundles\Theme\Parameters;

final class CreateThemeParameters
{
    /** @var string */
    private $title;

    /** @var string */
    private $description;

    /** @var string|null */
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
        string $preview = null,
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

    public function hasPreview(): bool
    {
        return $this->preview !== null;
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