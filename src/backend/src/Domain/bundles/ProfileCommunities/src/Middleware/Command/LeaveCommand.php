<?php
namespace Domain\ProfileCommunities\Middleware\Command;

use Application\Exception\NotImplementedException;
use Psr\Http\Message\ServerRequestInterface;

class LeaveCommand extends Command
{
    public function __invoke(ServerRequestInterface $request) {
        throw new NotImplementedException;
    }
}