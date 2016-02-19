<?php
namespace ThemeEditor\Middleware\Command;

use Psr\Http\Message\ServerRequestInterface;

class DeleteThemeCommand extends Command
{
    public function run(ServerRequestInterface $request)
    {
        $themeId = $request->getAttribute('themeId');

        $themeEditorService = $this->getThemeEditorService();
        $themeEditorService->destroy($themeId);

        return [
            'success' => true
        ];
    }
}