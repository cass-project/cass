<?php
namespace EmailVerification\Middleware\Command;

use Psr\Http\Message\ServerRequestInterface;

class RequestCommand extends Command
{
    public function run(ServerRequestInterface $request)
    {
        throw new \Exception('Not implemented');
    }
}