<?php
namespace ThemeEditor\Middleware\Request;

use Application\Tools\RequestParams\RequestParams;
use Psr\Http\Message\ServerRequestInterface;

class GetThemeRequest extends RequestParams
{
    protected function generateParams(ServerRequestInterface $request)
    {
        return false;
    }
}