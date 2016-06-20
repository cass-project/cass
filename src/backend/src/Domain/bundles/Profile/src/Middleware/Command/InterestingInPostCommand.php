<?php
namespace Domain\Profile\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Domain\Profile\Exception\ProfileNotFoundException;
use Domain\Profile\Middleware\Request\InterestingInRequest;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class InterestingInPostCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $profileId = (int) $request->getAttribute('profileId');
            $profile = $this->profileService->getProfileById($profileId);

            $this->validation->validateIsProfileOwnedByAccount(
                $this->currentAccountService->getCurrentAccount(),
                $this->profileService->getProfileById($profileId)
            );

            $themeIds = array_map('intval', explode(',', (new InterestingInRequest($request))->getParameters()->getThemeIds()));

            $this->profileService->setInterestingInThemes($profileId, array_unique(array_merge($profile->getInterestingInIds(), $themeIds)));

            $responseBuilder->setStatusSuccess()->setJson([
                'interesting_in_ids' => $profile->getInterestingInIds()
            ]);
        } catch (ProfileNotFoundException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusNotFound();
        }
    }
}