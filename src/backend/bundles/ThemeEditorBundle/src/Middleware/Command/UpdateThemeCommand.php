<?php
namespace ThemeEditor\Middleware\Command;

use Psr\Http\Message\ServerRequestInterface;

class UpdateThemeCommand extends Command
{
    public function run(ServerRequestInterface $request)
    {
        $body = json_decode($request->getBody(), true);
        $themeId = $request->getAttribute('themeId');
        $title = $body['title'];

        $themeEditorService = $this->getThemeEditorService();
        $themeEditorService->update($themeId, $title);

        return [
            'success' => true
        ];
    }
}