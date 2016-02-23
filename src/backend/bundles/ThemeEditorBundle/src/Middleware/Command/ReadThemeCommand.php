<?php
namespace ThemeEditor\Middleware\Command;

use Psr\Http\Message\ServerRequestInterface;
use ThemeEditor\Middleware\Request\GetThemeRequest;

class ReadThemeCommand extends Command
{
    public function run(ServerRequestInterface $request)
    {
        $themeEditorService = $this->getThemeEditorService();
        $entities = $themeEditorService->read(GetThemeRequest::factory($request));

        return [
            'entities' => $entities,
            'total' => count($entities),
            'success' => true
        ];
    }
}