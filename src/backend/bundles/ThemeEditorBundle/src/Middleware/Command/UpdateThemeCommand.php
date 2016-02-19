<?php
namespace ThemeEditor\Middleware\Command;

use Psr\Http\Message\RequestInterface;

class UpdateThemeCommand extends Command
{
    public function run(RequestInterface $request)
    {
        $body = json_decode($request->getBody(), true);
        $themeId = $body['id'];
        $title = $body['title'];

        $themeEditorService = $this->getThemeEditorService();
        $themeEditorService->update($themeId, $title);

        return [
            'success' => true
        ];
    }

}