<?php
namespace Domain\Theme\Strategy\Traits;

trait ThemeIdsAwareEntityTrait
{
    /**
     * @Column(type="json_array", name="theme_ids")
     * @var int[]
     */
    private $themeIds = [];

    public function getThemeIds(): array
    {
        return array_unique(array_filter((array) $this->themeIds, function($input) {
            return is_numeric($input);
        }));
    }

    public function setThemeIds(array $themeIds): array
    {
        $this->themeIds = array_unique(array_filter((array) $themeIds, function($input) {
            return is_numeric($input);
        }));

        return $this->themeIds;
    }
}