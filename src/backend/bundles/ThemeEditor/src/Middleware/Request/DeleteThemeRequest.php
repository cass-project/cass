<?php
namespace ThemeEditor\Middleware\Request;


use Common\Tools\RequestParams\RequestParams;
use Data\Repository\Theme\Parameters\DeleteThemeParameters;
use Psr\Http\Message\ServerRequestInterface;

class DeleteThemeRequest extends RequestParams
{
    protected function generateParams(ServerRequestInterface $request)
    {
        $themeId = (int) $request->getAttribute('themeId');

        return new DeleteThemeParameters($themeId);
    }
}