<?php
namespace ProfileIM\Middleware\Command;

use Auth\Service\CurrentAccountService;
use Profile\Service\ProfileService;
use ProfileIM\Service\ProfileIMService;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\Console\Exception\CommandNotFoundException;

abstract class Command
{
    const COMMAND_SEND = 'send';
    const COMMAND_UNREAD = 'unread';
    const COMMAND_MESSAGES = 'messages';

    /** @var CurrentAccountService */
    protected $currentAccountService;
    /** @var ProfileIMService */

    protected $profileIMService;

    /** @var  ProfileService */
    protected $profileService;

    public function setCurrentAccountService($currentAccountService): self
    {
        $this->currentAccountService = $currentAccountService;
        return $this;
    }

    public function setProfileIMService($profileIMService): self
    {
        $this->profileIMService = $profileIMService;
        return $this;
    }

    public function setProfileService(ProfileService $profileService): self
    {
        $this->profileService = $profileService;
        return $this;
    }

    static public function factory(
        ServerRequestInterface $request,
        CurrentAccountService $currentAccountService,
        ProfileIMService $profileIMService,
        ProfileService $profileService)
    {
        $command = self::factoryCommand($request->getAttribute('command'));

        return $command
            ->setCurrentAccountService($currentAccountService)
            ->setProfileIMService($profileIMService)
            ->setProfileService($profileService);
    }

    static private function factoryCommand(string $command): Command
    {
        switch($command) {
            default:
                throw new CommandNotFoundException(sprintf("Command %s::%s not found", self::class, $command));
            case self::COMMAND_SEND:
                return new SendCommand();
            case self::COMMAND_UNREAD:
                return new UnreadCommand();
            case self::COMMAND_MESSAGES:
                return new MessagesCommand();
        }
    }

    abstract public function run(ServerRequestInterface $request);
}