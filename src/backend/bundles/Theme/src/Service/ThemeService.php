<?php
namespace Theme\Service;

use Auth\Service\CurrentAccountService;
use Theme\Entity\Theme;
use Theme\Repository\ThemeRepository;

class ThemeService
{
    /** @var CurrentAccountService */
    private $currentAccountService;

    /** @var ThemeRepository */
    private $themeRepository;

    public function __construct(CurrentAccountService $currentAccountService, ThemeRepository $themeRepository)
    {
        $this->currentAccountService = $currentAccountService;
        $this->themeRepository = $themeRepository;
    }

    public function createTheme(string $title, string $description, int $parentId = null): Theme
    {
        return $this->themeRepository->createTheme($title, $description, $parentId);
    }

    public function getThemeById(int $themeId)
    {
        return $this->themeRepository->getThemeById($themeId);
    }

    /** @return Theme[] */
    public function getAllThemes(): array
    {
        return $this->themeRepository->getAllThemes();
    }

    /** @return Theme[] */
    public function getThemesAsTree(int $parentId = null): array
    {
        $this->themeRepository->getAllThemes();

        return $this->themeRepository->getThemesByParentId($parentId);
    }
}