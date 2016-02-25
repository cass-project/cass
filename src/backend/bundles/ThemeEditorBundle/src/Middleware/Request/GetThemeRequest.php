<?php
namespace ThemeEditor\Middleware\Request;

use Application\Tools\RequestParams\RequestParams;
use Psr\Http\Message\ServerRequestInterface;

class GetThemeRequest implements RequestParams
{
    public function __construct(ServerRequestInterface $request)
    {
    }
}