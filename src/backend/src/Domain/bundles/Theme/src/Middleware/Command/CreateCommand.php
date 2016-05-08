<?php
namespace Domain\Theme\Middleware\Command;

use Psr\Http\Message\ServerRequestInterface;
use Domain\Theme\Middleware\Request\CreateThemeRequest;

final class CreateCommand extends Command
{
    public function run(ServerRequestInterface $request) {
        $params = (new CreateThemeRequest($request))->getParameters();
        $theme = $this->themeService->createTheme($params['title'], $params['description'], $params['parent_id']);

        return [
            'entity' => $theme->toJSON()
        ];
    }
}