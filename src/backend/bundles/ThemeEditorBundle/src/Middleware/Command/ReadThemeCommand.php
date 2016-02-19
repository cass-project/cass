<?php
namespace ThemeEditor\Middleware\Command;

use Psr\Http\Message\ServerRequestInterface;

class ReadThemeCommand extends Command
{
    public function run(ServerRequestInterface $request)
    {
        $themeEditorService = $this->getThemeEditorService();
        $entities = $themeEditorService->read();

        return [
            'entities' => $entities,
            'total' => count($entities),
            'success' => true
        ];
    }
}