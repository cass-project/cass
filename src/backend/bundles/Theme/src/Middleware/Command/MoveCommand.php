<?php
namespace Theme\Middleware\Command;

use Common\Tools\SerialManager\SerialManager;
use Psr\Http\Message\ServerRequestInterface;

final class MoveCommand extends Command
{
    public function run(ServerRequestInterface $request) {
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

        return [
            'entity' => $theme->toJSON()
        ];
    }
}