<?php
namespace ThemeEditor\Middleware\Request;

use Application\Tools\RequestParams\RequestParams;
use Data\Repository\Theme\Parameters\MoveThemeParameters;
use Psr\Http\Message\ServerRequestInterface;

class MoveThemeRequest extends RequestParams
{
    protected function generateParams(ServerRequestInterface $request)
    {
        $themeId = (int) $request->getAttribute('themeId');
        $position = (int) $request->getAttribute('position');

        switch($parentId = $request->getAttribute('parentThemeId')) {
            case 0:
            case null:
            case 'null':
            case 'root':
            case 'none':
                $parentId = 0;
                break;

            default:
                $parentId = (int) $parentId;
                break;
        }

        return new MoveThemeParameters($themeId, $parentId, $position);
    }
}