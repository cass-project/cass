<?php
namespace CASS\Domain\Profile\Middleware\Command;

use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use CASS\Domain\Profile\Exception\LastProfileException;
use CASS\Domain\Profile\Exception\ProfileNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DeleteCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $profileId = (int) $request->getAttribute('profileId');
            $profile = $this->profileService->getProfileById($profileId);

            $this->validation->validateIsProfileOwnedByAccount($this->currentAccountService->getCurrentAccount(), $profile);
            $this->profileService->deleteProfile($profileId);

            $responseBuilder
                ->setStatusSuccess()
                ->setJson([
                    'current_profile_id' => $this->currentAccountService->getCurrentAccount()->getCurrentProfile()->getId()
                ]);
        } catch (LastProfileException $e) {
            $responseBuilder
                ->setStatusConflict()
                ->setError($e);
        } catch (ProfileNotFoundException $e) {
            $responseBuilder
                ->setStatusNotFound()
                ->setError($e);
        }

        return $responseBuilder->build();
    }
}