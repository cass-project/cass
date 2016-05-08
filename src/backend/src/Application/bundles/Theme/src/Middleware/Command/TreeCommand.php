<?php
namespace Application\Theme\Middleware\Command;

use Psr\Http\Message\ServerRequestInterface;
use Application\Theme\Entity\Theme;

final class TreeCommand extends Command
{
    public function run(ServerRequestInterface $request) {
        return [
            'entities' => $this->buildJSON($this->themeService->getThemesAsTree())
        ];
    }

    private function buildJSON(array $themes) {
        return array_map(function(Theme $theme) {
            $result = $theme->toJSON();
            $result['children'] = $theme->hasChildren() ? $this->buildJSON($theme->getChildren()->toArray()) : [];

            return $result;
        }, $themes);
    }
}