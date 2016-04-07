<?php
namespace ThemeEditor\Middleware\Command;

use Psr\Http\Message\ServerRequestInterface;
use ThemeEditor\Middleware\Request\MoveThemeRequest;

class MoveThemeCommand extends Command
{
    public function run(ServerRequestInterface $request)
    {
        $themeEditorService = $this->getThemeEditorService();
        $themeEditorService->move((new MoveThemeRequest($request))->getParameters());

        return [];
    }
}