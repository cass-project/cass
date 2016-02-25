<?php
namespace Application\Tools\RequestParams;

use Psr\Http\Message\ServerRequestInterface;

interface RequestParams
{
    public function __construct(ServerRequestInterface $request);
}