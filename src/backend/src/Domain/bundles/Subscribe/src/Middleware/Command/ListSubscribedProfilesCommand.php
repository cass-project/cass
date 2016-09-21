<?php
namespace CASS\Domain\Bundles\Subscribe\Middleware\Command;

use CASS\Domain\Bundles\Profile\Exception\ProfileNotFoundException;
use CASS\Util\Seek;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;

class ListSubscribedProfilesCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $body = $request->getParsedBody();
            $profileId = $request->getAttribute('profileId');
            $profile = $this->profileService->getProfileById($profileId);

            $seek = new Seek(100, (int)$body['offset'], (int)$body['limit']);
            $entities = $this->subscribeService->listSubscribedProfiles($profile, $seek);

            return $responseBuilder
                ->setJson([
                    'entities' => $entities
                ])
                ->setStatusSuccess()
                ->build();
        } catch (ProfileNotFoundException $e) {
            return $responseBuilder
                ->setStatusNotFound()
                ->build();
        }
    }
}