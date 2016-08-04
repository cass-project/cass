<?php
namespace Domain\Theme\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Domain\Theme\Exception\ThemeNotFoundException;
use Domain\Theme\Middleware\Request\UpdateThemeRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UpdateCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $parameters = (new UpdateThemeRequest($request))->getParameters();
            $themeEntity = $this->themeService->updateTheme((int) $request->getAttribute('themeId'), $parameters);

            $responseBuilder
                ->setJson([
                    'entity' => $themeEntity->toJSON()
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