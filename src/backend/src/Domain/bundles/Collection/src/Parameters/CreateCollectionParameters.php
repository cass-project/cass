<?php
namespace CASS\Domain\Bundles\Collection\Parameters;

class CreateCollectionParameters
{
    /** @var string */
    private $ownerSID;

    /** @var string */
    private $title;

    /** @var string */
    private $description;

    /** @var int[] */
    private $themeIds = [];

    public function __construct(string $ownerSID, string $title, string $description, array $themeIds = [])
    {
        $this->ownerSID = $ownerSID;
        $this->title = $title;
        $this->description = $description;
        $this->themeIds = $themeIds;
    }

    public function getOwnerSID(): string
    {
        return $this->ownerSID;
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