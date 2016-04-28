<?php
namespace EmailVerification\Middleware\Command;

use Account\Entity\Account;
use Psr\Http\Message\ServerRequestInterface;

class RequestCommand extends Command
{
    public function run(ServerRequestInterface $request)
    {
        try {
            $this->getEmailVerificationService()->requestForProfile(
                new Account(),
                $request->getAttribute('newEmail')
            );
        } catch (\Exception $e) {
            throw new \Exception($e);
        }

        return [];
    }
}