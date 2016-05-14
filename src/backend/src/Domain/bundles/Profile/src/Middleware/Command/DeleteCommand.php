<?php
namespace Domain\Profile\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Domain\Profile\Exception\LastProfileException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DeleteCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface {
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