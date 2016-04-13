<?php
namespace Collection\Middleware\Command;

use Collection\Service\CollectionService;
use Common\Exception\CommandNotFoundException;
use Psr\Http\Message\ServerRequestInterface;

abstract class Command
{
    const COMMAND_CREATE = 'create';
    const COMMAND_DELETE = 'delete';
    const COMMAND_LIST = 'list';
    const COMMAND_MOVE = 'move';
    const COMMAND_UPDATE = 'update';

    /** @var CollectionService */
    private $collectionService;

    public function setCollectionService(CollectionService $collectionService)
    {
        $this->collectionService = $collectionService;
    }

    public function getCollectionService() : CollectionService
    {
        return $this->collectionService;
    }

    public static function factory(ServerRequestInterface $request, CollectionService $collectionService)
    {
        $command = self::factoryCommand($request->getAttribute('command'));
        $command->setCollectionService($collectionService);

        return $command;
    }

    private static function factoryCommand(string $command): Command
    {
        switch($command) {
            default:
                throw new CommandNotFoundException(sprintf("Command %s::%s not found", self::class, $command));

            case self::COMMAND_CREATE:
                return new CreateCommand();

            case self::COMMAND_DELETE:
                return new DeleteCommand();

            case self::COMMAND_LIST:
                return new ListCommand();

            case self::COMMAND_MOVE:
                return new MoveCommand();

            case self::COMMAND_UPDATE:
                return new UpdateCommand();
        }
    }

    abstract public function run(ServerRequestInterface $request);
}