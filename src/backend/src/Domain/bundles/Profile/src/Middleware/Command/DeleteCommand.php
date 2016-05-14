<?php
namespace Domain\Profile\Middleware\Command;

use Application\Exception\BadCommandCallException;
use Application\REST\Response\ResponseBuilder;
use Domain\Profile\Exception\LastProfileException;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface as Response;

class DeleteCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): Response {
        try {
            $profileId = $this->validateProfileId($request->getAttribute('profileId'));
            $currentAccountId = $this->currentAccountService->getCurrentAccount()->getId();

            $this->profileService->deleteProfile($profileId, $currentAccountId);

            return $responseBuilder
                ->setStatusSuccess()
                ->build();
        }catch(LastProfileException $e){
            throw new BadCommandCallException($e->getMessage());
        }
    }
}