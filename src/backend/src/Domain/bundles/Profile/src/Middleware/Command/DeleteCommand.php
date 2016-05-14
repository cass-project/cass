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
            $currentAccount = $this->currentAccountService->getCurrentAccount();
            
            $profileId = $this->validateProfileId($request->getAttribute('profileId'));
            $currentAccountId = $currentAccount->getId();

            $this->profileService->deleteProfile($profileId, $currentAccountId);

            return $responseBuilder
                ->setStatusSuccess()
                ->setJson([
                    'current_profile_id' => $currentAccount->getCurrentProfile()->getId()
                ])
                ->build();
        }catch(LastProfileException $e){
            return $responseBuilder
                ->setStatusConflict()
                ->setError($e)
                ->build();
        }
    }
}