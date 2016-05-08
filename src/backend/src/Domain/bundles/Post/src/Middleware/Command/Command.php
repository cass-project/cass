<?php
namespace Domain\Post\Middleware\Command;

use Domain\Auth\Service\CurrentAccountService;
use Application\Exception\CommandNotFoundException;
use Domain\Post\Service\PostService;
use Psr\Http\Message\ServerRequestInterface;

abstract class Command
{
    const COMMAND_CREATE = 'create';
    const COMMAND_EDIT = 'edit';
    const COMMAND_DELETE = 'delete';
    const COMMAND_GET = 'get';

    /** @var PostService */
    protected $postService;

    /** @var CurrentAccountService */
    protected $currentProfileService;

    abstract public function run(ServerRequestInterface $request);

    public function setPostService(PostService $postService): self {
        $this->postService = $postService;
        return $this;
    }

    public function setCurrentProfileService(CurrentAccountService $currentProfileService) {
        $this->currentProfileService = $currentProfileService;
        return $this;
    }

    public static function factory(ServerRequestInterface $request, CurrentAccountService $currentAccountService, PostService $postService) {
        $command = self::factoryCommand($request->getAttribute('command'));

        return $command
            ->setCurrentProfileService($currentAccountService)
            ->setPostService($postService);
    }

    private static function factoryCommand(string $command) {
        switch($command) {
            default:
                throw new CommandNotFoundException(sprintf("Command %s::%s not found", self::class, $command));
            case self::COMMAND_CREATE:
                return new CreateCommand();
            case self::COMMAND_EDIT:
                return new EditCommand();
            case self::COMMAND_DELETE:
                return new DeleteCommand();
            case self::COMMAND_GET:
                return new GetCommand();
        }
    }
}