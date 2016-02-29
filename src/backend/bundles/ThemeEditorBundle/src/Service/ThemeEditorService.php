<?php
namespace ThemeEditor\Service;

use Data\Repository\ThemeRepository;
use Host\Service\CurrentHostService;
use ThemeEditor\Middleware\Request\DeleteThemeRequest;
use ThemeEditor\Middleware\Request\GetThemeRequest;
use ThemeEditor\Middleware\Request\MoveThemeRequest;
use ThemeEditor\Middleware\Request\PutThemeRequest;
use ThemeEditor\Middleware\Request\UpdateThemeRequest;

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

    public function create(PutThemeRequest $putThemeRequest) {
        return $this->themeRepository->create($this->currentHostService->getCurrentHost(), $putThemeRequest);
    }

    public function read(GetThemeRequest $getThemeRequest) {
        return $this->themeRepository->getThemes($getThemeRequest);
    }

    public function update(UpdateThemeRequest $updateThemeRequest) {
        return $this->themeRepository->update($updateThemeRequest);
    }

    public function move(MoveThemeRequest $moveThemeRequest) {
        return $this->themeRepository->move($moveThemeRequest);
    }

    public function delete(DeleteThemeRequest $deleteThemeRequest) {
        return $this->themeRepository->delete($deleteThemeRequest);
    }
}