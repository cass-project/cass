<?php
namespace Profile\Middleware\Command;

use Common\REST\Exceptions\UnknownActionException;
use Psr\Http\Message\ServerRequestInterface;

abstract class Command
{
    public static function factory(ServerRequestInterface $request): Command
    {
        $action = $request->getAttribute('command');

        switch ($action) {
            default:
                throw new UnknownActionException;

            case 'get':
                return new GetCommand();

            case 'create':
        }
    }

    abstract public function run(ServerRequestInterface $request);
}
