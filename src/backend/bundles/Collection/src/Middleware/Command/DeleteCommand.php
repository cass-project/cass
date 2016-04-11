<?php
namespace Collection\Middleware\Command;

use Psr\Http\Message\ServerRequestInterface;

class DeleteCommand extends Command
{
    public function run(ServerRequestInterface $request)
    {
        return [];
    }
}