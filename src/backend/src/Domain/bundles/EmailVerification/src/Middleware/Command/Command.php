<?php
namespace Domain\EmailVerification\Middleware\Command;

use Domain\Auth\Service\CurrentAccountService;
use Application\Exception\CommandNotFoundException;
use Domain\EmailVerification\Service\EmailVerificationService;
use Psr\Http\Message\ServerRequestInterface;

abstract class Command
{
    const COMMAND_REQUEST = 'request';
    const COMMAND_CONFIRM = 'confirm';

    /** @var EmailVerificationService */
    private $emailVerificationService;
    private $currentAccountService;

    public function setEmailVerificationService(EmailVerificationService $emailVerificationService)
    {
        $this->emailVerificationService = $emailVerificationService;
    }

    public function getEmailVerificationService() : EmailVerificationService {
        return $this->emailVerificationService;
    }

    public function setCurrentAccountService(CurrentAccountService $currentAccountService)
    {
        $this->currentAccountService = $currentAccountService;
    }

    public function getCurrentAccountService() : CurrentAccountService {
        return $this->currentAccountService;
    }

    public static function factory(ServerRequestInterface $request, EmailVerificationService $emailVerificationService, CurrentAccountService $currentAccountService)
    {
        $command = self::factoryCommand($request->getAttribute('command'));
        $command->setEmailVerificationService($emailVerificationService);
        $command->setCurrentAccountService($currentAccountService);

        return $command;
    }

    private static function factoryCommand(string $command): Command
    {
        switch($command) {
            default:
                throw new CommandNotFoundException(sprintf("Command %s::%s not found", self::class, $command));

            case self::COMMAND_REQUEST:
                return new RequestCommand();

            case self::COMMAND_CONFIRM:
                return new ConfirmCommand();
        }
    }

    abstract public function run(ServerRequestInterface $request);
}