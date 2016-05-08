<?php
namespace Application\EmailVerification\Middleware\Command;

use Psr\Http\Message\ServerRequestInterface;

class ConfirmCommand extends Command
{
    public function run(ServerRequestInterface $request)
    {
        throw new \Exception('Not implemented');
    }
}