<?php
namespace Collection\Middleware\Command;

use Psr\Http\Message\ServerRequestInterface;

class ListCommand extends Command
{
    public function run(ServerRequestInterface $request)
    {
        return [];
    }
}