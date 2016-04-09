<?php
namespace Profile\Middleware\Command;

use Psr\Http\Message\ServerRequestInterface;

class CreateCommand extends Command
{
    public function run(ServerRequestInterface $request)
    {
        return [];
    }
}