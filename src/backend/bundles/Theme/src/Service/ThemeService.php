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
}