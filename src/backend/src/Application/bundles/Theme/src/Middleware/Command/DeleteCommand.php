<?php
namespace Application\Theme\Middleware\Command;

use Psr\Http\Message\ServerRequestInterface;

final class DeleteCommand extends Command
{
    public function run(ServerRequestInterface $request)
    {
        $this->themeService->deleteTheme($request->getAttribute('themeId'));

        return [];
    }
}