<?php
namespace Application\Theme\Middleware\Command;

use Psr\Http\Message\ServerRequestInterface;
use Application\Theme\Middleware\Request\UpdateThemeRequest;

final class UpdateCommand extends Command
{
    public function run(ServerRequestInterface $request) {
        $params = (new UpdateThemeRequest($request))->getParameters();
        $theme = $this->themeService->updateTheme(
            (int) $request->getAttribute('themeId'),
            (string) $params['title'],
            (string) $params['description']
        );

        return [
            'entity' => $theme->toJSON()
        ];
    }
}