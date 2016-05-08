<?php
namespace Application\Profile\Middleware\Command;

use Application\Profile\Exception\NotOwnProfileException;
use Application\Profile\Middleware\Request\InterestingInRequest;
use Psr\Http\Message\ServerRequestInterface;

class InterestingInPutCommand extends Command
{
    public function run(ServerRequestInterface $request)
    {
        $profileId = (int) $request->getAttribute('profileId');

        if(! $this->validateIsOwnProfile($profileId)) {
            throw new NotOwnProfileException(sprintf('Application\Profile with ID `%s` is not yours', $profileId));
        }
        
        $interestingInRequest = new InterestingInRequest($request);
        $interestingInParameters = $interestingInRequest->getParameters();

        $this->profileService->setInterestingInParameters($profileId, $interestingInParameters);
        return ['success'=> TRUE];
    }
}