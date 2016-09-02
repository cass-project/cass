<?php
namespace CASS\Domain\Collection\Parameters;

class EditCollectionParameters
{
    /** @var string */
    private $title;

    /** @var string */
    private $description;

    /** @var int[] */
    private $themeIds = [];

    public function __construct(string $title, string $description, array $themeIds = [])
    {
        $this->title = $title;
        $this->description = $description;
        $this->themeIds = $themeIds;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getThemeIds(): array
    {
        return $this->themeIds;
    }
}