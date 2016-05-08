<?php
namespace Application\Profile\Middleware\Parameters;

class ExpertInParameters
{
    /** @var int[] */
    private $themeIds = [];

    public function __construct(array $themeIds) {
        $this->themeIds = $themeIds;
    }

    public function getThemeIds(): array {
        return $this->themeIds;
    }
}