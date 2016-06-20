<?php
namespace Domain\Profile\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Domain\Profile\Exception\ProfileNotFoundException;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class InterestingInDeleteCommand extends Command
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

            $themeIds = array_map('intval', explode(',', $request->getAttribute('theme_ids')));

            $this->profileService->setInterestingInThemes($profileId, array_filter($profile->getInterestingInIds(), function (int $themeId) use ($themeIds) {
                return !in_array($themeId, $themeIds);
            }));

            $responseBuilder->setStatusSuccess()->setJson([
                'interesting_in_ids' => $profile->getInterestingInIds()
            ]);
        } catch (ProfileNotFoundException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusNotFound();
        }

        return $responseBuilder->build();
    }
}