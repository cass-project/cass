<?php
namespace Domain\Profile\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Domain\Profile\Exception\NotOwnProfileException;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface as Response;

class InterestingInDeleteCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): Response {
        $profileId = (int) $request->getAttribute('profileId');

        if(! $this->validateIsOwnProfile($profileId)) {
            throw new NotOwnProfileException(sprintf('Domain\Profile with ID `%s` is not yours', $profileId));
        }

        $interestingInParameters = explode(',',$request->getAttribute('theme_ids'));

        $this->profileService->deleteInterestingInParameters($profileId, $interestingInParameters);

        return $responseBuilder
            ->setStatusSuccess()
            ->build();
    }
}