<?php
namespace Community\Middleware\Command;

use Common\Exception\NotImplementedException;
use Psr\Http\Message\ServerRequestInterface;

final class CreateCommand extends Command
{
    public function run(ServerRequestInterface $request): array
    {
        throw new NotImplementedException;
    }
}