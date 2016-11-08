<?php
namespace CASS\Domain\Bundles\Subscribe\Middleware\Command;

use CASS\Domain\Bundles\Subscribe\Exception\UnknownSubscribeException;
use CASS\Domain\Bundles\Theme\Exception\ThemeNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;

class UnSubscribeThemeCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $currentProfile = $this->currentAccountService->getCurrentAccount()->getCurrentProfile();

        try {
            $theme = $this->themeService->getThemeById($request->getAttribute('themeId'));
            $this->subscribeService->unSubscribeTheme($currentProfile, $theme);

            $responseBuilder
                ->setStatusSuccess();
        } catch (UnknownSubscribeException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusNotFound();
        } catch (ThemeNotFoundException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusNotFound();
        }

        return $responseBuilder->build();
    }
}