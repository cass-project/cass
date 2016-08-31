<?php
namespace Domain\Theme\Middleware\Command;

use CASS\Application\REST\Response\ResponseBuilder;
use Domain\Theme\Entity\Theme;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ListAllCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $themes = $this->themeService->getAllThemes();

        $responseBuilder
            ->setJson([
                'total' => count($themes),
                'entities' => array_map(function(Theme $theme) {
                    return $theme->toJSON();
                }, $themes)
            ])
            ->setStatusSuccess();

        return $responseBuilder->build();
    }
}