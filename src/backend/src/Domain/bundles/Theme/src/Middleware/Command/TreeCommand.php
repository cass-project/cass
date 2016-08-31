<?php
namespace Domain\Theme\Middleware\Command;

use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Domain\Theme\Entity\Theme;

final class TreeCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $responseBuilder
            ->setJson([
                'entities' => $this->buildJSON($this->themeService->getThemesAsTree())
            ])
            ->setStatusSuccess();

        return $responseBuilder->build();
    }

    private function buildJSON(array $themes) {
        return array_map(function(Theme $theme) {
            $result = $theme->toJSON();
            $result['children'] = $theme->hasChildren() ? $this->buildJSON($theme->getChildren()->toArray()) : [];

            return $result;
        }, $themes);
    }
}