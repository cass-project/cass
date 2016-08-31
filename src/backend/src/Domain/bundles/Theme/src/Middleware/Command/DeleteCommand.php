<?php
namespace Domain\Theme\Middleware\Command;

use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use Domain\Theme\Exception\ThemeNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class DeleteCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $this->themeService->deleteTheme($request->getAttribute('themeId'));

            $responseBuilder->setStatusSuccess();
        }catch(ThemeNotFoundException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusNotFound();
        }

        return $responseBuilder->build();
    }
}