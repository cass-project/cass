<?php
namespace Domain\Theme\Middleware\Command;

use Psr\Http\Message\ServerRequestInterface;

final class GetCommand extends Command
{
    public function run(ServerRequestInterface $request) {
        return [
            'entity' => $this->themeService->getThemeById($request->getAttribute('themeId'))->toJSON()
        ];
    }
}