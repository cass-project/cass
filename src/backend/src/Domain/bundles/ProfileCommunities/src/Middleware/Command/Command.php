<?php
namespace Domain\ProfileCommunities\Middleware\Command;

use Application\Exception\CommandNotFoundException;
use Domain\ProfileCommunities\Service\ProfileCommunitiesService;
use Psr\Http\Message\ServerRequestInterface;

abstract class Command
{
    const COMMAND_JOIN = 'join';
    const COMMAND_LEAVE = 'leave';
    const COMMAND_LIST = 'joined-communities';

    /** @var ProfileCommunitiesService */
    protected $profileCommunitiesService;

    public function setProfileCommunitiesService(ProfileCommunitiesService $profileCommunitiesService)
    {
        $this->profileCommunitiesService = $profileCommunitiesService;
    }

    abstract public function __invoke(ServerRequestInterface $request);

    public static function factory(ServerRequestInterface $request, ProfileCommunitiesService $profileCommunitiesService)
    {
        $command = self::factoryCommand($request->getAttribute('command'));
        $command->setProfileCommunitiesService($profileCommunitiesService);

        return $command;
    }

    private static function factoryCommand(string $command): Command
    {
        switch($command) {
            default:
                throw new CommandNotFoundException(sprintf("Command %s::%s not found", self::class, $command));
            case self::COMMAND_JOIN:
                return new JoinCommand();
            case self::COMMAND_LEAVE:
                return new LeaveCommand();
            case self::COMMAND_LIST:
                return new ListCommand();
        }
    }
}