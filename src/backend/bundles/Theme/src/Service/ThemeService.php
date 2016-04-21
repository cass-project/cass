<?php
namespace Theme\Service;

use Auth\Service\CurrentAccountService;
use Common\Tools\SerialManager\SerialManager;
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

    public function moveTheme(int $themeId, int $newParentThemeId = null, int $position = SerialManager::POSITION_LAST): Theme
    {
        return $this->themeRepository->moveTheme($themeId, $newParentThemeId, $position);
    }

    public function updateTheme(int $themeId, string $title, string $description = ''): Theme
    {
        return $this->themeRepository->updateTheme($themeId, $title, $description);
    }

    public function deleteTheme(int $themeId)
    {
        $this->themeRepository->deleteTheme($themeId);
    }
}