<?php
namespace ProfileIM\Middleware\Command;

use Psr\Http\Message\ServerRequestInterface;

class MessagesCommand extends Command
{
    public function run(ServerRequestInterface $request)
    {
        throw new \Exception('Not implemented');
    }
}