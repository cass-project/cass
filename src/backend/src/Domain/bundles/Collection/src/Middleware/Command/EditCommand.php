<?php
namespace Domain\Collection\Middleware\Command;

use Application\Exception\NotImplementedException;
use Psr\Http\Message\ServerRequestInterface;

class EditCommand extends Command
{
    public function run(ServerRequestInterface $request)
    {
        throw new NotImplementedException;
    }
}