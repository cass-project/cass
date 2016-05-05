<?php
namespace Community\Middleware\Command;

use Common\Exception\NotImplementedException;
use Psr\Http\Message\ServerRequestInterface;

final class EditCommand extends Command
{
    public function run(ServerRequestInterface $request)
    {
        throw new NotImplementedException;
    }
}