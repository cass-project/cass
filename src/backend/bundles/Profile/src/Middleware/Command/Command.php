<?php
namespace Profile\Middleware\Command;

use Psr\Http\Message\ServerRequestInterface;

abstract class Command
{

    static public function factory(ServerRequestInterface $request)
    {
        $action = $request->getAttribute('command');

        switch ($action) {
            case 'create':
                //return new CreateCommand();
                break;
            case 'update':
                //return new UpdateCommand();
                break;
            case 'delete':
                //return new DeleteCommand();
                break;
            default:
                return new ReadCommand();
                break;
        }
    }

    abstract public function run(ServerRequestInterface $request);
}
