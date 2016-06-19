<?php
namespace Domain\Profile\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Domain\Profile\Exception\NotOwnProfileException;
use Domain\Profile\Middleware\Request\InterestingInRequest;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class InterestingInPutCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $profileId = (int)$request->getAttribute('profileId');

        $this->validation->validateIsProfileOwnedByAccount(
            $this->currentAccountService->getCurrentAccount(),
            $this->profileService->getProfileById($profileId)
        );

        $parameters = (new InterestingInRequest($request))->getParameters();

        $this->profileService->setInterestingInParameters($profileId, $parameters);

        return $responseBuilder
            ->setStatusSuccess()
            ->build();
    }
}