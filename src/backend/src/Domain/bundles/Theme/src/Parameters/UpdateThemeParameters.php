<?php
namespace Domain\Theme\Parameters;

final class UpdateThemeParameters
{
    /** @var string */
    private $title;

    /** @var string */
    private $description;

    /** @var string|null */
    private $preview;

    /** @var string|null */
    private $specifyURL;

    public function __construct(
        string $title,
        string $description,
        string $preview = null,
        string $specifyURL = null
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->preview = $preview;
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

    public function hasChangedPreview(): bool
    {
        return $this->preview !== null;
    }

    public function getPreview(): string
    {
        return $this->preview;
    }

    public function hasSpecifiedURL(): bool
    {
        return $this->specifyURL !== null;
    }

    public function getSpecifiedURL(): string
    {
        return $this->specifyURL;
    }
}