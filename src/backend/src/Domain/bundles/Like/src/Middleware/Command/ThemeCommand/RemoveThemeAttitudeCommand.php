<?php

namespace CASS\Domain\Bundles\Like\Middleware\Command\ThemeCommand;

use CASS\Domain\Bundles\Like\Entity\Attitude;
use CASS\Domain\Bundles\Like\Entity\AttitudeFactory;
use CASS\Domain\Bundles\Like\Exception\AttitudeNotFoundException;
use CASS\Domain\Bundles\Theme\Exception\ThemeNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;

class RemoveThemeAttitudeCommand extends ThemeCommand
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $themeId = $request->getAttribute('themeId');
            $theme = $this->themeService->getThemeById($themeId);

            // устанавливаем владельца
            $attitudeFactory = new AttitudeFactory($this->currentIPService->getCurrentIP(), $this->currentAccountService);
            $attitude = $attitudeFactory->getAttitude();
            $attitude->setResource($theme);


            // устанавливаем свойства
            $attitude->setResource($theme);
            $attitude = $this->likeThemeService->getAttitude($attitude);

            switch($attitude->getAttitudeType()) {
                case Attitude::ATTITUDE_TYPE_LIKE:
                    $this->likeThemeService->removeLike($theme, $attitude);
                    break;
                case Attitude::ATTITUDE_TYPE_DISLIKE:
                    $this->likeThemeService->removeDislike($theme, $attitude);
                    break;
            }

            $responseBuilder
                ->setStatusSuccess()
                ->setJson([
                    'success' => true,
                    'entity' => $theme->toJSON(),
                ]);

        } catch(AttitudeNotFoundException $e) {
            $responseBuilder
                ->setError($e)
                ->setJson(['success' => false])
                ->setStatusNotFound();
        } catch(ThemeNotFoundException $e) {
            $responseBuilder
                ->setError($e)
                ->setJson(['success' => false])
                ->setStatusNotFound();
        } catch(\Exception $e) {
            $responseBuilder
                ->setError($e)
                ->setJson(['success' => false])
                ->setStatusNotFound();
        }
        return $responseBuilder->build();
    }

}