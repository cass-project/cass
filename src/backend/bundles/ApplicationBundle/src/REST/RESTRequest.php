<?php
namespace Application\REST;

use Psr\Http\Message\ServerRequestInterface;

interface RESTRequest
{
    public static function factory(ServerRequestInterface $request);
}