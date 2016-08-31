<?php
namespace CASS\Application\REST\Request\Params;

use Psr\Http\Message\ServerRequestInterface;

interface RequestParamsInterface
{
    public function __construct(ServerRequestInterface $request);
    public function getParameters();
}