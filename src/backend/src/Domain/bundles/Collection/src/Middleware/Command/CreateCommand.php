<?php
namespace Domain\Collection\Middleware\Command;

use Application\Exception\NotImplementedException;
use Psr\Http\Message\ServerRequestInterface;

class CreateCommand extends Command
{
    public function run(ServerRequestInterface $request) {
        throw new NotImplementedException;
    }
}