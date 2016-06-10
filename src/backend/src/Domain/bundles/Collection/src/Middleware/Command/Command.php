<?php
namespace Domain\Collection\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Domain\Collection\Service\CollectionService;
use Application\Exception\CommandNotFoundException;
use Psr\Http\Message\ServerRequestInterface;

abstract class Command
{
    const COMMAND_CREATE = 'create';
    const COMMAND_DELETE = 'delete';
    const COMMAND_EDIT = 'edit';
    const COMMAND_IMAGE_UPLOAD = 'image-upload';

    /** @var CollectionService */
    protected $collectionService;

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
            case self::COMMAND_EDIT:
                return new EditCommand();
            case self::COMMAND_IMAGE_UPLOAD:
                return new ImageUploadCommand();
        }
    }

    abstract public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder);
}