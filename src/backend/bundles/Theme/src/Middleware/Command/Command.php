<?php
namespace Theme\Middleware\Command;

use Auth\Service\CurrentAccountService;
use Common\Exception\CommandNotFoundException;
use Psr\Http\Message\ServerRequestInterface;
use Theme\Service\ThemeService;

abstract class Command
{
    const COMMAND_CREATE = 'create';
    const COMMAND_DELETE = 'delete';
    const COMMAND_GET = 'get';
    const COMMAND_LIST_ALL = 'list-all';
    const COMMAND_MOVE = 'move';
    const COMMAND_TREE = 'tree';
    const COMMAND_UPDATE = 'update';

    /** @var CurrentAccountService */
    protected $currentAccountService;

    /** @var ThemeService */
    protected $themeService;

    public function setCurrentAccountService(CurrentAccountService $currentAccountService): self {
        $this->currentAccountService = $currentAccountService;
        return $this;
    }

    public function setThemeService(ThemeService $themeService): self {
        $this->themeService = $themeService;
        return $this;
    }

    static public function factory(
        ServerRequestInterface $request,
        CurrentAccountService $currentAccountService,
        ThemeService $themeService)
    {
        $command = self::factoryCommand($request->getAttribute('command'));

        return $command
            ->setCurrentAccountService($currentAccountService)
            ->setThemeService($themeService);
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
            case self::COMMAND_GET:
                return new GetCommand();
            case self::COMMAND_LIST_ALL:
                return new ListAllCommand();
            case self::COMMAND_MOVE:
                return new MoveCommand();
            case self::COMMAND_TREE:
                return new TreeCommand();
            case self::COMMAND_UPDATE:
                return new UpdateCommand();
        }
    }

    abstract public function run(ServerRequestInterface $request);
}