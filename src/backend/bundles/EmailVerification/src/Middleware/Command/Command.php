<?php
namespace EmailVerification\Middleware\Command;

use Common\Exception\CommandNotFoundException;
use EmailVerification\Service\EmailVerificationService;
use Psr\Http\Message\ServerRequestInterface;

abstract class Command
{
    const COMMAND_REQUEST = 'request';
    const COMMAND_CONFIRM = 'confirm';

    /** @var EmailVerificationService */
    private $emailVerificationService;

    public function setEmailVerificationService(EmailVerificationService $emailVerificationService)
    {
        $this->emailVerificationService = $emailVerificationService;
    }

    public static function factory(ServerRequestInterface $request, EmailVerificationService $emailVerificationService)
    {
        $command = self::factoryCommand($request->getAttribute('command'));
        $command->setEmailVerificationService($emailVerificationService);

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