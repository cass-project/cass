<?php
namespace Domain\Community\Middleware\Command;

use Application\Exception\NotImplementedException;
use Psr\Http\Message\ServerRequestInterface;

final class CreateCommand extends Command
{
    public function run(ServerRequestInterface $request): array
    {
        throw new NotImplementedException;
    }
}