<?php
namespace ThemeEditor\Middleware\Command;

use Psr\Http\Message\RequestInterface;

class DeleteThemeCommand extends Command
{
    public function run(RequestInterface $request)
    {
        $body = json_decode($request->getBody(), true);
        $themeId = $body['id'];

        $themeEditorService = $this->getThemeEditorService();
        $themeEditorService->destroy($themeId);

        return [
            'success' => true
        ];
    }

}