<?php
namespace Domain\Profile\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Domain\Profile\Exception\NotOwnProfileException;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class InterestingInDeleteCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $profileId = (int)$request->getAttribute('profileId');

        $this->validation->validateIsProfileOwnedByAccount(
            $this->currentAccountService->getCurrentAccount(),
            $this->profileService->getProfileById($profileId)
        );

        $interestingInParameters = explode(',', $request->getAttribute('theme_ids'));

        $this->profileService->deleteInterestingInParameters($profileId, $interestingInParameters);

        return $responseBuilder
            ->setStatusSuccess()
            ->build();
    }
}