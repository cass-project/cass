<?php
namespace CASS\Domain\Bundles\Theme\Middleware\Command;

use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use CASS\Domain\Bundles\Theme\Exception\ThemeNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class GetCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $responseBuilder
                ->setJson([
                    'entity' => $this->themeService->getThemeById($request->getAttribute('themeId'))->toJSON()
                ])
                ->setStatusSuccess();
        }catch(ThemeNotFoundException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusNotFound();
        }

        return $responseBuilder->build();
    }
}