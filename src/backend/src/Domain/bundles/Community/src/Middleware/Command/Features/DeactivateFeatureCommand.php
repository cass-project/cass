<?php
namespace Domain\Community\Middleware\Command\Feature;

use Application\REST\Response\ResponseBuilder;
use Domain\Community\Exception\CommunityNotFoundException;
use Domain\Community\Exception\FeatureIsActivatedException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DeactivateFeatureCommand extends AbstractFeatureCommand
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $communityId = $request->getAttribute('communityId');
            $featureCode = $request->getAttribute('feature');

            $community = $this->communityService->getCommunityById($communityId);

            $this->communityFeatureService->deactivateFeature($featureCode, $community);

            $responseBuilder->setStatusSuccess();
        }catch(FeatureIsActivatedException $e) {
            $responseBuilder
                ->setStatusConflict()
                ->setError($e);
        }catch(CommunityNotFoundException $e) {
            $responseBuilder
                ->setStatusNotFound()
                ->setError($e);
        }

        return $responseBuilder->build();
    }
}