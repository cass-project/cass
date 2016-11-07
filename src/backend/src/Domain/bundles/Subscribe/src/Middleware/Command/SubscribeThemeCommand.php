<?php
namespace CASS\Domain\Bundles\Subscribe\Middleware\Command;

use CASS\Domain\Bundles\Theme\Exception\ThemeNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;

class SubscribeThemeCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $currentProfile = $this->currentAccountService->getCurrentAccount()->getCurrentProfile();

        try {
            $theme = $this->themeService->getThemeById($request->getAttribute('themeId'));
            $entity = $this->subscribeService->subscribeTheme($currentProfile, $theme);

            $responseBuilder
                ->setJson([
                    'subscribe' => $this->subscribeFormatter->formatSingle($entity),
                ])
                ->setStatusSuccess();
        } catch (ThemeNotFoundException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusNotFound();
        }

        return $responseBuilder->build();
    }
}