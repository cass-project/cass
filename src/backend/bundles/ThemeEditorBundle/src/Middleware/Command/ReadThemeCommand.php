<?php
namespace ThemeEditor\Middleware\Command;

use Psr\Http\Message\RequestInterface;

class ReadThemeCommand extends Command
{
    public function run(RequestInterface $request)
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