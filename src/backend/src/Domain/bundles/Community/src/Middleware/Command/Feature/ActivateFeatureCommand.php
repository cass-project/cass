<?php
namespace Domain\Community\Middleware\Command\Feature;

use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use Domain\Community\Exception\CommunityNotFoundException;
use Domain\Community\Exception\FeatureIsActivatedException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ActivateFeatureCommand extends AbstractFeatureCommand
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface 
    {
        try {
            $communityId = $request->getAttribute('communityId');
            $featureCode = $request->getAttribute('feature');

            $community = $this->communityService->getCommunityById($communityId);

            $this->communityFeatureService->activateFeature($featureCode, $community);

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