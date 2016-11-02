<?php
namespace CASS\Domain\Bundles\Subscribe\Middleware\Command;

use CASS\Domain\Bundles\Profile\Exception\ProfileNotFoundException;
use CASS\Domain\Bundles\Subscribe\Entity\Subscribe;
use CASS\Util\Seek;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;

class ListSubscribedThemesCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $bodyJson = json_decode($request->getBody()->getContents(), true);
            $profileId = $request->getAttribute('profileId');
            $profile = $this->profileService->getProfileById($profileId);

            $seek = new Seek(100, $bodyJson['offset'], $bodyJson['limit']);
            $entities = $this->subscribeService->listSubscribedThemes($profile, $seek);

            return $responseBuilder
                ->setJson([
                    'success' => true,
                    'total' => count($entities),
                    'entities' => array_map(function (Subscribe $subscribe) {
                        return $subscribe->toJSON();
                    }, $entities)
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