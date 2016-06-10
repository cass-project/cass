<?php
namespace Domain\Collection\Parameters;

class CreateCollectionParameters
{
    /** @var int */
    private $authorProfileId;

    /** @var string */
    private $title;

    /** @var string */
    private $description;

    /** @var int|null */
    private $themeId;

    public function __construct(int $authorProfileId, string $title, string $description, int $themeId = null)
    {
        $this->authorProfileId = $authorProfileId;
        $this->title = $title;
        $this->description = $description;
        $this->themeId = $themeId;
    }

    public function getAuthorProfileId(): int
    {
        return $this->authorProfileId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getThemeId(): int
    {
        return $this->themeId;
    }

    public function hasThemeId(): bool
    {
        return $this->themeId !== null;
    }
}