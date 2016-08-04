<?php
namespace Domain\Theme\Parameters;

final class UpdateThemeParameters
{
    /** @var string */
    private $title;

    /** @var string */
    private $description;

    /** @var string */
    private $preview;

    /** @var string|null */
    private $specifyURL;

    public function __construct(
        string $title,
        string $description,
        string $preview,
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

    public function getPreview(): string
    {
        return $this->preview;
    }

    public function hasSpecifiedURL(): bool
    {
        return $this->specifyURL !== null;
    }

    public function getSpecifyURL(): string
    {
        return $this->specifyURL;
    }
}