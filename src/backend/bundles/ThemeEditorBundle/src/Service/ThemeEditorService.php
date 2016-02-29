<?php
namespace ThemeEditor\Service;

use Data\Repository\Theme\Parameters\CreateThemeParameters;
use Data\Repository\Theme\Parameters\DeleteThemeParameters;
use Data\Repository\Theme\Parameters\MoveThemeParameters;
use Data\Repository\Theme\Parameters\UpdateThemeParameters;
use Data\Repository\Theme\ThemeRepository;
use Host\Service\CurrentHostService;

class ThemeEditorService
{
    /** @var CurrentHostService */
    private $currentHostService;

    /** @var ThemeRepository */
    private $themeRepository;

    public function __construct(CurrentHostService $currentHostService, ThemeRepository $themeRepository)
    {
        $this->currentHostService = $currentHostService;
        $this->themeRepository = $themeRepository;
    }

    public function create(CreateThemeParameters $createThemeParameters) {
        return $this->themeRepository->create($this->currentHostService->getCurrentHost(), $createThemeParameters);
    }

    public function read() {
        return $this->themeRepository->getThemes();
    }

    public function update(UpdateThemeParameters $updateThemeParameters) {
        return $this->themeRepository->update($updateThemeParameters);
    }

    public function move(MoveThemeParameters $moveThemeParameters) {
        return $this->themeRepository->move($moveThemeParameters);
    }

    public function delete(DeleteThemeParameters $deleteThemeParameters) {
        return $this->themeRepository->delete($deleteThemeParameters);
    }
}