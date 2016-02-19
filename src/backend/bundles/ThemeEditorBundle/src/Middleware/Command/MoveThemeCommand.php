<?php
namespace ThemeEditor\Middleware\Command;

use Psr\Http\Message\ServerRequestInterface;

class MoveThemeCommand extends Command
{
    public function run(ServerRequestInterface $request)
    {
        $themeId = $request->getAttribute('themeId');
        $themeNewParentId = $request->getAttribute('parentThemeId');

        $themeEditorService = $this->getThemeEditorService();
        $themeEditorService->move($themeId, $themeNewParentId);

        return [
            'success' => true
        ];
    }

}