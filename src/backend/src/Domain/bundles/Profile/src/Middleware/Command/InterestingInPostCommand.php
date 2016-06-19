<?php
namespace Domain\Profile\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Domain\Profile\Middleware\Request\InterestingInRequest;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class InterestingInPostCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $profileId = (int)$request->getAttribute('profileId');

        $this->validation->validateIsProfileOwnedByAccount(
            $this->currentAccountService->getCurrentAccount(),
            $this->profileService->getProfileById($profileId)
        );

        $interestingInRequest = new InterestingInRequest($request);
        $interestingInParameters = $interestingInRequest->getParameters();

        $this->profileService->mergeInterestingInParameters($profileId, $interestingInParameters);

        return $responseBuilder
            ->setStatusSuccess()
            ->build();
    }
}