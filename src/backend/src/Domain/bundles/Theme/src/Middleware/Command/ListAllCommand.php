<?php
namespace Domain\Theme\Middleware\Command;

use Domain\Theme\Entity\Theme;
use Psr\Http\Message\ServerRequestInterface;

final class ListAllCommand extends Command
{
    public function run(ServerRequestInterface $request) {
        $themes = $this->themeService->getAllThemes();

        return [
            'total' => count($themes),
            'entities' => array_map(function(Theme $theme) {
                return $theme->toJSON();
            }, $themes)
        ];
    }
}