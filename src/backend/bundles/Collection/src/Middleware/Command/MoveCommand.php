<?php
namespace Collection\Middleware\Command;

use Psr\Http\Message\ServerRequestInterface;

class MoveCommand extends Command
{
    public function run(ServerRequestInterface $request)
    {
        return [];
    }
}