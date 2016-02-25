<?php
namespace ThemeEditor\Middleware\Command;

use Application\Service\SchemaService;
use ThemeEditor\Service\ThemeEditorService;
use Psr\Http\Message\ServerRequestInterface;

abstract class Command
{
    /** @var ThemeEditorService */
    private $themeEditorService;

    public function setThemeEditorService(ThemeEditorService $themeEditorService)
    {
        $this->themeEditorService = $themeEditorService;
    }

    protected function getThemeEditorService(): ThemeEditorService
    {
        return $this->themeEditorService;
    }

    abstract public function run(ServerRequestInterface $request);
}