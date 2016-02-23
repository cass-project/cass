<?php
namespace ThemeEditor\Middleware\Command;

use Psr\Http\Message\ServerRequestInterface;
use ThemeEditor\Middleware\Request\UpdateThemeRequest;

class UpdateThemeCommand extends Command
{
    public function run(ServerRequestInterface $request)
    {
        $themeEditorService = $this->getThemeEditorService();
        $themeEditorService->update(UpdateThemeRequest::factory($request));

        return [
            'success' => true
        ];
    }
}