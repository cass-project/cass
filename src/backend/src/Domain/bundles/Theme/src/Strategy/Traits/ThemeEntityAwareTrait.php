<?php
namespace Domain\Theme\Strategy\Traits;

use Domain\Theme\Entity\Theme;

trait ThemeAwareEntityTrait
{
    /**
     * @ManyToOne(targetEntity="Domain\Theme\Entity\Theme")
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