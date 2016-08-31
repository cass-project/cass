<?php
namespace Domain\Community\Middleware\Command\Feature;

use CASS\Application\REST\Response\ResponseBuilder;
use Domain\Community\Exception\CommunityNotFoundException;
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