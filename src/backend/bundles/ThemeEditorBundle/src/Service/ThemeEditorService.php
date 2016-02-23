<?php
namespace ThemeEditor\Service;

use Data\Repository\ThemeRepository;
use ThemeEditor\Middleware\Request\DeleteThemeRequest;
use ThemeEditor\Middleware\Request\GetThemeRequest;
use ThemeEditor\Middleware\Request\MoveThemeRequest;
use ThemeEditor\Middleware\Request\PutThemeRequest;
use ThemeEditor\Middleware\Request\UpdateThemeRequest;

class ThemeEditorService
{
    /** @var ThemeRepository */
    private $themeRepository;

    public function __construct(ThemeRepository $themeRepository) {
        $this->themeRepository = $themeRepository;
    }

    public function create(PutThemeRequest $putThemeRequest) {
        return $this->themeRepository->create($putThemeRequest);
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