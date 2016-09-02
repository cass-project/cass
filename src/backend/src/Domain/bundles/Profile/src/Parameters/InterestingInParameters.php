<?php
namespace CASS\Domain\Bundles\Profile\Parameters;

class InterestingInParameters
{
    /** @var int[] */
    private $themeIds = [];

    public function __construct(array $themeIds)
    {
        $this->themeIds = $themeIds;
    }

    public function getThemeIds(): array
    {
        return $this->themeIds;
    }
}