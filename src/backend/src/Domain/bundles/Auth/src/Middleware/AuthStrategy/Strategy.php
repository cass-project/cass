<?php
namespace Domain\Auth\Middleware\AuthStrategy;

use Psr\Http\Message\ServerRequestInterface;

abstract class Strategy
{
    protected $request;

    public function __construct(ServerRequestInterface $request)
    {
        $this->request = $request;
    }

    abstract public function isAPIKeyAvailable(): bool ;
    abstract public function getAPIKey();
}