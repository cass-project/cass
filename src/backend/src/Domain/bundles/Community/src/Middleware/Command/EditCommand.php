<?php
namespace Domain\Community\Middleware\Command;

use Application\Exception\NotImplementedException;
use Psr\Http\Message\ServerRequestInterface;

final class EditCommand extends Command
{
    public function run(ServerRequestInterface $request)
    {
        throw new NotImplementedException;
    }
}