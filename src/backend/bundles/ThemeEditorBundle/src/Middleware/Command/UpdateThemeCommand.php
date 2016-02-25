<?php
namespace ThemeEditor\Middleware\Command;

use Psr\Http\Message\ServerRequestInterface;
use ThemeEditor\Middleware\Request\UpdateThemeRequest;

class UpdateThemeCommand extends Command
{
    public function run(ServerRequestInterface $request)
    {
        $themeEditorService = $this->getThemeEditorService();
        $themeEditorService->update(new UpdateThemeRequest($request));

        return [
            'success' => true
        ];
    }
}