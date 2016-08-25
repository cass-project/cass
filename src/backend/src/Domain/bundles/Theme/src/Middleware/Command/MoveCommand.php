<?php
namespace Domain\Theme\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use CASS\Util\SerialManager\SerialManager;
use Domain\Theme\Exception\ThemeNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class MoveCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $themeId = (int) $request->getAttribute('themeId');
            $parentThemeId = (int) $request->getAttribute('parentThemeId');
            $position = (int) $request->getAttribute('position');

            if($parentThemeId == 0 || $parentThemeId == 'null') {
                $parentThemeId = null;
            }

            if($position === "last") {
                $position = SerialManager::POSITION_LAST;
            }else if($position === "first") {
                $position = 1;
            }

            $theme = $this->themeService->moveTheme($themeId, $parentThemeId, $position);

            $responseBuilder
                ->setJson([
                    'entity' => $theme->toJSON()
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