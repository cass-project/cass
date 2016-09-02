<?php
namespace CASS\Domain\Bundles\Theme\Middleware\Command;

use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use CASS\Domain\Bundles\Theme\Exception\ThemeWithThisIdExistsException;
use CASS\Domain\Bundles\Theme\Middleware\Request\CreateThemeRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class CreateCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $parameters = (new CreateThemeRequest($request))->getParameters();
            $theme = $this->themeService->createTheme($parameters);

            $responseBuilder
                ->setJson([
                    'entity' => $theme->toJSON()
                ])
                ->setStatusSuccess();
        }catch(ThemeWithThisIdExistsException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusConflict();
        }

        return $responseBuilder->build();
    }
}