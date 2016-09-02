<?php
namespace CASS\Domain\Bundles\Theme\Strategy\Traits;

use CASS\Domain\Bundles\Theme\Entity\Theme;

trait ThemeAwareEntityTrait
{
    /**
     * @ManyToOne(targetEntity="CASS\Domain\Bundles\Theme\Entity\Theme")
     * @JoinColumn(name="theme_id", referencedColumnName="id")
     * @var Theme
     */
    private $theme;

    public function getTheme(): Theme
    {
        return $this->theme;
    }
    
    public function hasTheme(): bool
    {
        return $this->theme !== null;
    }

    public function setTheme(Theme $theme): Theme
    {
        $this->theme = $theme;

        return $theme;
    }
}