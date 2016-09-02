<?php
namespace CASS\Domain\Community\Middleware\Command\Feature;

use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use CASS\Domain\Community\Exception\CommunityNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class IsFeatureActivatedCommand extends AbstractFeatureCommand
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $communityId = $request->getAttribute('communityId');
            $featureCode = $request->getAttribute('feature');

            $community = $this->communityService->getCommunityById($communityId);

            $isActivated = $this->communityFeatureService->isFeatureActivated($featureCode, $community);

            $responseBuilder
                ->setStatusSuccess()
                ->setJson([
                    'is_feature_activated' => $isActivated
                ]);
        }catch(CommunityNotFoundException $e) {
            $responseBuilder
                ->setStatusNotFound()
                ->setError($e);
        }

        return $responseBuilder->build();
    }
}