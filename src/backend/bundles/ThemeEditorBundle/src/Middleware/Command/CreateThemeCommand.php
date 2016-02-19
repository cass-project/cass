<?php
namespace ThemeEditor\Middleware\Command;

use Psr\Http\Message\RequestInterface;

class CreateThemeCommand extends Command
{
    public function run(RequestInterface $request)
    {
        $body = json_decode($request->getBody(), true);
        $title = $body['title'];
        $parentId = $body['parent_id'] ?? null;

        $themeEditorService = $this->getThemeEditorService();
        $theme = $themeEditorService->create($title, $parentId);

        return [
            'id' => $theme->getId(),
            'success' => true
        ];
    }
}