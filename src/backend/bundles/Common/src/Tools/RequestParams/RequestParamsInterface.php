<?php
namespace Common\Tools\RequestParams;

use Psr\Http\Message\ServerRequestInterface;

interface RequestParamsInterface
{
    public function __construct(ServerRequestInterface $request);
    public function getParameters();
}