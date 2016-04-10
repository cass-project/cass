<?php
namespace Profile\Middleware\Command;

use Common\REST\Exceptions\UnknownActionException;
use Psr\Http\Message\ServerRequestInterface;

abstract class Command
{
    const COMMAND_CREATE = 'create';
    const COMMAND_DELETE = 'delete';
    const COMMAND_GET = 'get';
    const COMMAND_GREETINGS_AS = 'greetings-as';
    const COMMAND_IMAGE_UPLOAD = 'image-upload';
    const COMMAND_UPDATE = 'update';

    public static function factory(ServerRequestInterface $request): Command
    {
        $action = $request->getAttribute('command');

        switch ($action) {
            default:
                throw new UnknownActionException;

            case self::COMMAND_CREATE:
                return new CreateCommand();

            case self::COMMAND_DELETE:
                return new DeleteCommand();

            case self::COMMAND_GET:
                return new GetCommand();

            case self::COMMAND_GREETINGS_AS:
                return new GreetingsAsCommand();

            case self::COMMAND_IMAGE_UPLOAD:
                return new ImageUploadCommand();

            case self::COMMAND_UPDATE:
                return new UpdateCommand();
        }
    }

    abstract public function run(ServerRequestInterface $request);
}
