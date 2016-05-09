<?php
namespace Domain\Community\Middleware\Command;

use Application\Exception\CommandNotFoundException;
use Domain\Community\Service\CommunityService;
use Psr\Http\Message\ServerRequestInterface;

abstract class Command
{
    const COMMAND_CREATE = 'create';
    const COMMAND_EDIT = 'edit';
    const COMMAND_IMAGE_UPLOAD = 'image-upload';

    /** @var CommunityService */
    protected $communityService;

    public function setCommunityService(CommunityService $communityService): self
    {
        $this->communityService = $communityService;
        return $this;
    }

    abstract public function run(ServerRequestInterface $request);

    public static function factory(ServerRequestInterface $request, CommunityService $communityService)
    {
        $command = self::factoryCommand($request->getAttribute('command'));
        $command->setCommunityService($communityService);

        return $command;
    }

    private static function factoryCommand(string $command)
    {
        switch($command) {
            default:
                throw new CommandNotFoundException(sprintf("Command %s::%s not found", self::class, $command));
            case self::COMMAND_CREATE:
                return new CreateCommand();
            case self::COMMAND_EDIT:
                return new EditCommand();
            case self::COMMAND_IMAGE_UPLOAD:
                return new ImageUploadCommand();
        }
    }
}