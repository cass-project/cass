<?php
namespace ThemeEditor\Middleware\Command;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use ThemeEditor\Service\ThemeEditorService;

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



    abstract public function run(RequestInterface $request);
}