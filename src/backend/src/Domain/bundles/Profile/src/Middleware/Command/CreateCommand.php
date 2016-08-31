<?php
namespace Domain\Profile\Middleware\Command;

use CASS\Application\Exception\BadCommandCallException;
use CASS\Application\REST\Response\ResponseBuilder;
use Domain\Profile\Exception\MaxProfilesReachedException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class CreateCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $account = $this->currentAccountService->getCurrentAccount();

        try {
            $profile = $this->profileService->createProfileForAccount($account);

            return $responseBuilder
                ->setStatusSuccess()
                ->setJson([
                    'entity' => $profile->toJSON()
                ])
                ->build();
        } catch (MaxProfilesReachedException $e) {
            throw new BadCommandCallException($e->getMessage());
        }
    }
}