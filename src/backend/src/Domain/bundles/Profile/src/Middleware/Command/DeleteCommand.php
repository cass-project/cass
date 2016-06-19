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
            $profileId = $request->getAttribute('profileId');
            
            $profile = $this->profileService->getProfileById($profileId);
            $reSwitch = $profile->isCurrent();

            $this->validation->validateIsProfileOwnedByAccount($this->currentAccountService->getCurrentAccount(), $profile);
            $this->profileService->deleteProfile($profileId);

            return $responseBuilder
                ->setStatusSuccess()
                ->setJson([
                    'current_profile_id' => $this->currentAccountService->getCurrentProfile()->getId()
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