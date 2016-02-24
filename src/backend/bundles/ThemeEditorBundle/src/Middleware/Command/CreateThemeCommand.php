<?php
namespace ThemeEditor\Middleware\Command;

use Psr\Http\Message\ServerRequestInterface;
use ThemeEditor\Middleware\Request\PutThemeRequest;

class CreateThemeCommand extends Command
{
    public function run(ServerRequestInterface $request)
    {
        $themeEditorService = $this->getThemeEditorService();
        $theme = $themeEditorService->create(PutThemeRequest::factory($request));

        return [
            'id' => $theme->getId(),
            'entity' => [
                $theme->toJSON()
            ],
            'success' => true
        ];
    }
}