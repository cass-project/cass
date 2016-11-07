<?php
namespace CASS\Domain\Bundles\Subscribe\Middleware\Command;

use CASS\Domain\Bundles\Profile\Exception\ProfileNotFoundException;
use CASS\Domain\Bundles\Subscribe\Exception\ConflictSubscribe;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;

class SubscribeProfileCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $currentProfile = $this->currentAccountService->getCurrentAccount()->getCurrentProfile();

        try {
            $profile = $this->profileService->getProfileById($request->getAttribute('profileId'));

            $entity = $this->subscribeService->subscribeProfile($currentProfile, $profile);
            

            $responseBuilder
                ->setJson([
                    'subscribe' => $this->subscribeFormatter->formatSingle($entity),
                ])
                ->setStatusSuccess();
        } catch (ConflictSubscribe $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusConflict();
        } catch (ProfileNotFoundException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusNotFound();
        }

        return $responseBuilder->build();
    }
}