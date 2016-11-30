<?php

namespace CASS\Domain\Bundles\Like\Middleware\Command\ThemeCommand;

use CASS\Domain\Bundles\Like\Entity\AttitudeFactory;
use CASS\Domain\Bundles\Like\Exception\AttitudeAlreadyExistsException;
use CASS\Domain\Bundles\Theme\Exception\ThemeNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;

class AddLikeThemeCommand extends ThemeCommand
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $themeId = $request->getAttribute('themeId');
            $theme = $this->themeService->getThemeById($themeId);

            $attitudeFactory = new AttitudeFactory($request, $this->currentAccountService);
            $attitude = $attitudeFactory->getAttitude();
            $attitude->setResource($theme);

            $this->likeThemeService->addLike($theme, $attitude);
            $responseBuilder
                ->setStatusSuccess()
                ->setJson([
                    'success' => true,
                    'entity' => $theme->toJSON(),
                ]);
        } catch(AttitudeAlreadyExistsException $e) {
            $responseBuilder
                ->setError($e)
                ->setJson(['success' => false])
                ->setStatusConflict();
        } catch(ThemeNotFoundException $e) {
            $responseBuilder
                ->setJson(['success' => false])
                ->setError($e)
                ->setStatusNotFound();
        } catch(\Exception $e) {
            $responseBuilder
                ->setJson([
                    'success' => false,
                ])
                ->setError($e);
        }

        return $responseBuilder->build();
    }

}