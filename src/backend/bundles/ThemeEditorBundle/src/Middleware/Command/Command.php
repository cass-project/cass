<?php
namespace ThemeEditor\Middleware\Command;

use ThemeEditor\Service\ThemeEditorService;
use Psr\Http\Message\ServerRequestInterface;

abstract class Command
{
    /**
     * @var ThemeEditorService
     */
    private $themeEditorService;

    /**
     * @param ThemeEditorService $themeEditorService
     */
    public function setThemeEditorService($themeEditorService)
    {
        $this->themeEditorService = $themeEditorService;
    }

    protected function getThemeEditorService()
    {
        if($this->themeEditorService === null) {
            throw new \Exception('No theme editor service available');
        }

        return $this->themeEditorService;
    }

    abstract public function run(ServerRequestInterface $request);
}