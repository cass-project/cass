<?php
namespace ThemeEditor\Middleware\Command;

use Psr\Http\Message\RequestInterface;

class MoveThemeCommand extends Command
{
    public function run(RequestInterface $request)
    {
        $body = json_decode($request->getBody(), true);
        $themeId = $body['id'];
        $themeNewParentId = $body['parent_id'];

        $themeEditorService = $this->getThemeEditorService();
        $themeEditorService->move($themeId, $themeNewParentId);

        return [
            'success' => true
        ];
    }
}