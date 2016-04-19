<?php
namespace Theme\Middleware\Command;

use Psr\Http\Message\ServerRequestInterface;

final class UpdateCommand extends Command
{
    public function run(ServerRequestInterface $request) {
        throw new \Exception('Not implemented');
    }
}