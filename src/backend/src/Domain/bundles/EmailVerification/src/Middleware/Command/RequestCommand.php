<?php
namespace CASS\Domain\Bundles\EmailVerification\Middleware\Command;

use Psr\Http\Message\ServerRequestInterface;

class RequestCommand extends Command
{
    public function run(ServerRequestInterface $request)
    {
        $this->getEmailVerificationService()->requestForProfile(
            $this->getCurrentAccountService()->getCurrentAccount(),
            $request->getAttribute('newEmail')
        );

        return [];
    }
}